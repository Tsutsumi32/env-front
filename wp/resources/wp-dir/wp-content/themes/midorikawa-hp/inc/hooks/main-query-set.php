<?php
/***************************************************
    メインクエリの条件指定
 ****************************************************/
function main_query_set($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    // デフォルト投稿ページの表示件数
    if ($query->is_archive()) {
        // 1ページの表示数
        $query->set('posts_per_page', ARCHIVE_NUM);
        // 昇順・降順
        $query->set('order', 'DESC');
        // 並び順条件(更新日)
        $query->set('orderby', 'modified');
        return;
    }
}
add_action('pre_get_posts', 'main_query_set');
