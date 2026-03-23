<?php
/***************************************************
    カスタム投稿タイプ設定
 ****************************************************/
function custom_post_setup()
{
    // カスタム投稿設定
    foreach (Post::getAll() as $post) {
        $settings = $post['post_type_settings'];
        register_post_type(
            $post['slug'],
            array(
                'labels' => array(
                    'menu_name' => $settings['label'],
                    'all_items' => $settings['label'] . '一覧',
                    'add_new' => '新規追加',
                    'search_items' => $settings['label'] . 'を検索',
                    'not_found' => $settings['label'] . 'は見つかりませんでした。',
                    'not_found_in_trash' => 'ゴミ箱に' . $settings['label'] . 'はありませんでした。'
                ),
                'public' => true,
                'query_var' => true,
                'show_in_rest' => true,
                'show_ui' => true,
                'supports' => $settings['supports'],
                'has_archive' => $settings['has_archive'],
                'hierarchical' => false,
                'menu_position' => $settings['menu_position'],
                'menu_icon' => 'dashicons-portfolio',
                'ys_show_works_publish_date' => 'both',
            )
        );

        // タクソノミ―設定
        $cat = $post['category_settings'];
        if(!empty($cat)) {
            register_taxonomy(
                $cat['slug'],
                $post['slug'],
                array(
                    'labels' => array(
                        'name' => 'カテゴリ',
                        'menu_name' => 'カテゴリ',
                        'add_new_item' => 'カテゴリを追加',
                    ),
                    'default_term' => array(
                        'name' => $cat['default']['label'],
                        'slug' => $cat['default']['slug'],
                        'description' => $cat['default']['label'],
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'show_in_rest' => true,
                    'show_admin_column' => true,
                )
            );
        }
    }
}
add_action('init', 'custom_post_setup');
