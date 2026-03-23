<?php
/**
 * OGP出力
 * 
 * このファイルでは、OGP（Open Graph Protocol）関連のメタタグを出力します。
 */

// ページ設定を取得
$pageConfig = PageConfig::get($pageId ?? '');
$pageTitle = $pageConfig['title'] ?? '';
$pageDescription = $pageConfig['description'] ?? '';
$pageUrl = $pageConfig['url'] ?? '';

// サイト情報を取得
$siteName = defined('SITE_NAME') ? SITE_NAME : 'Sample Site';
$siteUrl = defined('SITE_URL') ? SITE_URL : 'http://localhost';

// タイトルの整形
if (empty($pageTitle) || $pageTitle === $siteName) {
    $ogTitle = $siteName;
} else {
    $ogTitle = $pageTitle . ' | ' . $siteName;
}

// ディスクリプションの取得
if (empty($pageDescription)) {
    $pageDescription = defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '';
}

// URLの取得
if (empty($pageUrl)) {
    $pageUrl = $siteUrl . $_SERVER['REQUEST_URI'];
} else {
    $pageUrl = $siteUrl . $pageUrl;
}

// OGP画像のURL
$ogImage = $siteUrl . '/assets/images/ogp.png';
?>
<meta property="og:title" content="<?php echo htmlspecialchars($ogTitle, ENT_QUOTES, 'UTF-8'); ?>">
<?php if (!empty($pageDescription)): ?>
<meta property="og:description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>
<meta property="og:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/png">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo htmlspecialchars($pageUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:site_name" content="<?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?>">

