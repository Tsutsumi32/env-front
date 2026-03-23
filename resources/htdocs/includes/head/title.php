<?php
/**
 * タイトル出力
 * 
 * このファイルでは、ページのtitleタグを出力します。
 * トップページの場合はサイト名のみ、それ以外のページの場合は「ページタイトル | サイト名」の形式で出力します。
 */

// ページ設定を取得
$pageConfig = PageConfig::get($pageId ?? '');
$pageTitle = $pageConfig['title'] ?? '';

// サイト名を取得
$siteName = defined('SITE_NAME') ? SITE_NAME : 'Sample Site';

// タイトルの整形
if (empty($pageTitle) || $pageTitle === $siteName) {
    $title = $siteName;
} else {
    $title = $pageTitle . ' | ' . $siteName;
}
?>
<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>

