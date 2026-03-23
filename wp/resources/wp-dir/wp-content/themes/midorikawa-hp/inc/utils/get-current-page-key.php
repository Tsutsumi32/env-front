<?php
/**
 * 現在ページのPageクラスのキー情報を取得する
 *
 * @return string|null キー文字列
 */
function get_current_page_key(): ?string
{
    $slug = get_current_slug();
    if (!$slug) return null;

    foreach (Page::getAll() as $key => $page) {
        if (($page['slug'] ?? null) === $slug) {
            return $key;
        }
    }

    foreach (Post::getAll() as $key => $post) {
        if (($post['slug'] ?? null) === $slug) {
            return $key;
        }
    }

    return null;
}

?>