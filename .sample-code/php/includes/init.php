<?php
/**
 * 共通ファイル読み込みエントリーポイント
 *
 * このファイルでは、全ページで共通して使用するファイルを一括で読み込みます。
 * 定数、ユーティリティ関数、ページ設定などが含まれます。
 */

// 定数の読み込み
require_once __DIR__ . '/consts/consts.php';

// ユーティリティ関数の読み込み
require_once __DIR__ . '/utils/render-img.php';

// ページ設定クラスの読み込み
require_once __DIR__ . '/pages/pages.php';

