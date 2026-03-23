<?php
/***************************************************
    通常エディタにし、編集部分を削除する
 ****************************************************/
add_action('init', function () {
    $settings = Post::getAll();
    foreach($settings as $key => $setting) {
        $config = Post::getPostTypeSettings($key);
        if($config['remove_editor']) {
            // 投稿タイプ「post」の本文欄を削除
            remove_post_type_support($key, 'editor');
        }
    }
});