<?php
/**************************************************************************
    プログラム上から投稿を登録・更新する実処理
    ※管理画面上から編集した投稿は対象外となる
    ※処理速度に時間がかかるため、本番では一度登録した後、本処理は取り除く想定
 **************************************************************************/
// 登録処理の読み込み
require __DIR__ . '/create-or-update-post.php';

// 登録情報を配列化する
// dataディレクトリ内の読み込むファイル名を配列に定義する
$files = [
    'vehicles.php',
    'factories.php',
    'medicals.php',
    'environments.php',
    'offices.php',
    'amusements.php',
    'agricultures.php',
    'facilities.php'
];

// 登録情報
$all_posts = [];
foreach ($files as $file) {
    $posts = require __DIR__ . '/data/' . $file;
    $all_posts = array_merge($all_posts, $posts);
}

// ベース時間を決める（必要に応じて固定値にしてもOK）

add_action('init', function () use ($all_posts, $base_time) {
    $base_time = time();

    foreach ($all_posts as $i => $data) {
        // post_dateが未指定の場合のみ自動で追加
        if (!isset($data['args']['post_date'])) {
            $data['args']['post_date'] = date('Y-m-d H:i:s', $base_time + $i);
        }

        $post_id = create_or_update_post(
            $data['args'],
            $data['meta'] ?? [],
            $data['taxonomies'] ?? []
        );

        if (is_wp_error($post_id)) {
            error_log('投稿エラー: ' . $post_id->get_error_message());
        } else {
            error_log("投稿作成成功: ID = $post_id");
        }
    }
});