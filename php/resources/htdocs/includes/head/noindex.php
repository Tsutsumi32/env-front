<?php
/**
 * noindex設定出力
 *
 * このファイルでは、noindexメタタグを出力します。
 * 検索エンジンにインデックスされないようにするページで使用します。
 */

// ページ設定を取得
$pageConfig = PageConfig::get($pageId ?? '');
$noindex = $pageConfig['noindex'] ?? false;
?>
<?php if ($noindex === true): ?>
<meta name="robots" content="noindex nofollow" />
<?php endif; ?>

