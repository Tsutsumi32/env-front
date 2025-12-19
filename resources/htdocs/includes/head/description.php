<?php
/**
 * ディスクリプション出力
 * 
 * このファイルでは、ページのdescriptionメタタグを出力します。
 */

// ページ設定を取得
$pageConfig = PageConfig::get($pageId ?? '');
$pageDescription = $pageConfig['description'] ?? '';

// デフォルトのディスクリプションを取得
if (empty($pageDescription)) {
    $pageDescription = defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '';
}
?>
<?php if (!empty($pageDescription)): ?>
<meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>

