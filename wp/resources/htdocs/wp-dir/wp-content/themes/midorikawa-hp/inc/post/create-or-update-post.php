<?php
if (!defined('ABSPATH')) exit;

/***************************************************
    プログラム上から投稿を登録・更新する処理
    ※管理画面上から編集した投稿は対象外となる
 ****************************************************/
// 管理画面上で編集した投稿にメタ情報を付与する(本メタ情報がある場合には、プログラム上からの更新は無視する)
// 該当のカスタム投稿を定義する
$manual_edit_meta_setting_slugs = [
    Post::PROCESSED_PRODUCTION,
    // 他の投稿タイプもあれば追加可能
];

foreach ($manual_edit_meta_setting_slugs as $post_type) {
    add_action("save_post_{$post_type}", function ($post_id, $post, $update) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (wp_is_post_revision($post_id)) return;
        if (!is_admin()) return;

        // 本当にこの投稿を編集したときだけ
        if (
            isset($_POST['post_ID']) &&
            intval($_POST['post_ID']) === intval($post_id)
        ) {
            update_post_meta($post_id, '_manual_edit', 1);
        }
    }, 10, 3);
}

/**
 * 投稿を作成または更新する汎用関数（ACF・画像・保護対応）
 */
function create_or_update_post($args = [], $meta = [], $taxonomies = [])
{
    if (!isset($args['post_type'])) {
        return new WP_Error('missing_data', 'post_typeは必須です。');
    }

    $post_type = $args['post_type'];
    $external_id = $meta['_external_id'] ?? null;
    $existing_post = null;

    if (!$external_id) {
        return new WP_Error('missing_external_id', '一意な _external_id が必須です。');
    }

    // _external_id による既存判定
    if ($external_id) {
        $existing_post = get_existing_post_by_meta('_external_id', $external_id, $post_type);
    }

    // アイキャッチ画像処理（パスを一時保存）
    $thumbnail_path = $args['_thumbnail_path'] ?? null;
    unset($args['_thumbnail_path']);

    // 手動編集された投稿はスキップ
    if ($existing_post) {
        if (get_post_meta($existing_post->ID, '_manual_edit', true)) {
            error_log("投稿ID {$existing_post->ID} は手動編集されているためスキップされました。");
            print_r(('aaa'));
            return $existing_post->ID;
        }

        $args['ID'] = $existing_post->ID;
        $post_id = wp_update_post($args);
    } else {
        $post_id = wp_insert_post($args);
    }

    if (is_wp_error($post_id)) return $post_id;

    // _external_id を保存（念のため）
    if ($external_id) {
        update_post_meta($post_id, '_external_id', $external_id);
    }

    // アイキャッチ画像設定
    if ($thumbnail_path) {
        $image_id = attach_local_image_to_post($thumbnail_path, $post_id);
        if ($image_id) {
            set_post_thumbnail($post_id, $image_id);
        } else {
            error_log("アイキャッチ画像の登録に失敗: {$thumbnail_path}");
        }
    }

    // カスタムフィールド（ACF含む）
    foreach ($meta as $key => $value) {
        // 画像ファイルはACF画像として処理
        if (is_string($value) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $value)) {
            if (function_exists('get_field_object')) {
                $field_object = get_field_object($key, $post_id);
                if (!$field_object) {
                    print_r("フィールド [$key] が投稿ID [$post_id] に紐づいていません。");

                    // 投稿IDなしで取得してみる
                    $global_field = get_field_object($key);
                    if ($global_field) {
                        print_r("フィールド [$key] は存在しています（グローバル）。type: " . $global_field['type']);
                    } else {
                        print_r("フィールド [$key] 自体が見つかりません。");
                    }
                }
                if ($field_object && $field_object['type'] === 'image') {
                    $image_id = attach_local_image_to_post($value, $post_id);
                    if ($image_id) {
                        update_field($key, $image_id, $post_id);
                        continue;
                    }
                }
            }
        }

        // 通常のフィールド処理
        if (function_exists('update_field')) {
            update_field($key, $value, $post_id);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }

    // タクソノミー
    foreach ($taxonomies as $taxonomy => $terms) {
        wp_set_object_terms($post_id, $terms, $taxonomy);
    }

    return $post_id;
}

/**
 * テーマ内のローカル画像をメディアに登録し、添付IDを返す
 */
function attach_local_image_to_post($relative_path, $post_id)
{
    $filename = basename($relative_path);

    // すでにアップロードされているか確認（ファイル名ベース）
    $existing = get_posts([
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'meta_query'     => [
            [
                'key'     => '_wp_attached_file',
                'value'   => $filename,
                'compare' => 'LIKE',
            ]
        ],
        'fields'         => 'ids',
    ]);

    if (!empty($existing)) {
        return $existing[0]; // 最初に見つかった添付IDを返す
    }

    // ファイルが存在しなければ false
    $full_path = get_template_directory() . '/' . ltrim($relative_path, '/');
    if (!file_exists($full_path)) return false;

    // ファイル情報
    $filetype = wp_check_filetype($filename, null);
    $upload = wp_upload_bits($filename, null, file_get_contents($full_path));
    if (!empty($upload['error'])) return false;

    // 添付情報を作成して登録
    $attachment = [
        'guid'           => $upload['url'],
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_file_name($filename),
        'post_content'   => '',
        'post_status'    => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);

    // メディア情報生成
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);

    return $attach_id;
}


/**
 * _external_id から既存投稿を取得
 */
function get_existing_post_by_meta($meta_key, $meta_value, $post_type)
{
    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => 1,
        'post_status'    => ['publish', 'draft', 'private'], // ゴミ箱除外
        'meta_query'     => [
            [
                'key'   => $meta_key,
                'value' => $meta_value,
            ],
        ],
        'fields' => 'ids',
    ];
    $query = new WP_Query($args);
    return $query->have_posts() ? get_post($query->posts[0]) : null;
}
