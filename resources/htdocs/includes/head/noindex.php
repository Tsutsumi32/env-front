<?php
/**
 * noindex設定出力
 *
 * このファイルでは、noindexメタタグを出力します。
 * 検索エンジンにインデックスされないようにするページで使用します。
 */

// noindex設定を取得
$noindex = Page::getNoindex($pageId ?? ''); ?>
<?php if ($noindex === true): ?>
<meta name="robots" content="noindex nofollow" />
<?php endif; ?>

