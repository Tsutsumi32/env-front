<?php
/**
 * ディスクリプション出力
 *
 * このファイルでは、ページのdescriptionメタタグを出力します。
 */

// ページ説明を取得
$pageDescription = Page::getDescription($pageId ?? ''); ?>
<?php if (!empty($pageDescription)): ?>
<meta name="description" content="<?php echo htmlspecialchars(
    $pageDescription,
    ENT_QUOTES,
    'UTF-8',
); ?>">
<?php endif; ?>

