<?php
/**
 * 共通ファイル読み込み・共通初期処理実行
 *
 * このファイルでは、全ページで共通して使用するファイルを一括で読み込みます。
 * 定数、ユーティリティ関数、ページ設定などが含まれます。
 * また、全ページで行うべき初期処理を実行します。
 */

// 定数の読み込み
require_once __DIR__ . '/consts/consts.php';

// ユーティリティ関数の読み込み
require_once __DIR__ . '/utils/render-img.php';

// ページ設定クラスの読み込み
require_once __DIR__ . '/pages/pages.php';

// 現在のURLからページIDを自動設定（各画面・レイアウトの両方で利用可能）
$pageId = PageConfig::getPageIdFromRequest();
