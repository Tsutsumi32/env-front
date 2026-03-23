<?php
/**
 * URLを取得する（アンカー優先引数）
 *
 * @param string $key ページキー(スラッグ)
 * @param string $anchor アンカー（例：'section1'）
 * @param array $query クエリパラメータ
 * @return string
 */
function get_url(string $key, string $anchor = '', array $query = []): string
{
    // クラスからurl(相対パス)取得
    if($key == '') {
        $url = home_url();
    } else {
        $path = Page::getUrl($key) ?? Post::getUrl($key);
        if (!$path) return '#'; // fallback
        // ルート
        $url = home_url($path);
    }

    // スラッシュ付与
    if (substr($url, -1) !== '/') {
        $url .= '/';
    }

    // クエリ付与
    if (!empty($query)) {
        $url .= '?' . http_build_query($query);
    }

    // アンカー付与
    if ($anchor !== '') {
        $url .= '#' . urlencode($anchor);
    }

    return esc_url($url);
}
