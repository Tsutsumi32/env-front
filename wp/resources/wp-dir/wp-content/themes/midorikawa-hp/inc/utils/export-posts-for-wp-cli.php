<?php
/***************************************************
    WP-CLIでサンプル投稿を作成するための情報を渡すファイル
 ****************************************************/
require_once __DIR__ . '/../../../../../wp-load.php';
require_once __DIR__ . '/../classes/Post.php';
Post::exportBashAssociativeArray();