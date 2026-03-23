<?php
/***************************************************
    CF7設定のロード用ファイル
 ****************************************************/

// CF7セットアップ
require_once __DIR__ . '/cf7-setup.php';

// CF7 pタグ無効化
require_once __DIR__ . '/cf7-remove-tag.php';

// CF7側のバリデーション定義
require_once __DIR__ . '/cft-validate.php';
?>