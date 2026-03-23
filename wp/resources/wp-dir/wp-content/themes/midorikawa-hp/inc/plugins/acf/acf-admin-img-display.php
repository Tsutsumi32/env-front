<?php

/***************************************************
 * 投稿タイプごとに一覧で表示する画像フィールドを定義
 ****************************************************/
$custom_thumbnail_fields = [
    Post::PRODUCT              => 'product_image1',
    Post::PROCESSED_PRODUCTION => 'processed-production_image1',
    // 他のカスタム投稿タイプを追加可能
];

/***************************************************
 * 投稿一覧に「サムネイル」カラムを追加
 ****************************************************/
foreach ($custom_thumbnail_fields as $post_type => $field_key) {
    add_filter("manage_{$post_type}_posts_columns", function ($columns) use ($field_key) {
        $columns[$field_key] = 'サムネイル';
        return $columns;
    });
}

/***************************************************
 * サムネイルカラムにACF画像を表示
 ****************************************************/
foreach ($custom_thumbnail_fields as $post_type => $field_key) {
    add_action("manage_{$post_type}_posts_custom_column", function ($column, $post_id) use ($field_key) {
        if ($column === $field_key) {
            $image = get_field($field_key, $post_id);

            if (is_array($image) && isset($image['ID'])) {
                echo wp_get_attachment_image($image['ID'], 'thumbnail');
            } elseif (is_numeric($image)) {
                echo wp_get_attachment_image($image, 'thumbnail');
            } elseif (is_string($image)) {
                echo '<img src="' . esc_url($image) . '" style="max-width:60px;" />';
            } else {
                echo '—';
            }
        }
    }, 10, 2);
}
