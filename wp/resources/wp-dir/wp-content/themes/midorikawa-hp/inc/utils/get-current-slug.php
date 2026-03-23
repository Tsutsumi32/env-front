<?php
/**
 * 現在ページのスラッグを取得する
 * トップページや404の場合は指定した文字列(画面キー)を返却する
 * 投稿一覧や詳細ページの場合は、該当のカスタム投稿スラッグを返却する
 *
 * @return string|null スラッグ（トップは 'top' など）、該当しなければ null
 */
function get_current_slug(): ?string
{
    global $post;

    // トップページ
    if (is_front_page() || is_home()) {
        return Page::TOP;
    }

    // 投稿・カスタム投稿の詳細ページ
    if (is_single()) {
        return get_post_type();
    }

    // 固定ページ
    if (is_page()) {
        return $post->post_name;
    }

    // 投稿タイプのアーカイブページ
    if (is_post_type_archive()) {
        return get_post_type();
    }

    // タクソノミー（カテゴリ・タグなど）
    if (is_tax() || is_category() || is_tag()) {
        $term = get_queried_object();
        return $term->slug ?? null;
    }

    // 404
    if (is_404()) {
        return Page::NOT_FOUND;
    }

    return null;
}
