<?php
/*****************************************************************
 * WP-CLIで　ACFの投稿を設定するファイル
 *****************************************************************/
?>

<?php
// 引数から投稿IDを取得
$post_id = $args[0] ?? null;
$post_type = $args[1] ?? null;

// 正常に引数が受け取れているか確認
if (!$post_id) {
    echo "投稿IDを指定してください。\n";
    exit;
}
// 正常に引数が受け取れているか確認
if (!$post_type) {
    echo "投稿スラッグを指定してください。\n";
    exit;
}

$fields = [];
// ACFのフィールドに値を設定する
if (!empty(AcfField::getField($post_type))) {
    foreach (AcfField::getField($post_type) as $item) {
        $sample = $item['sample'];

        // // sampleが配列ならランダムで1つ取得
        // if (is_array($sample)) {
        //     $val = $sample[array_rand($sample)];
        // } else {
        //     $val = $sample;
        // }
        $val = $sample;
        $fields[$item['slug']] = $val;
    }

    // ACFフィールドを更新
    if (function_exists('update_field')) {
        foreach ($fields as $key => $val) {
            update_field($key, $val, $post_id);
            echo "ACFフィールド '{$key}' に値を設定しました。\n";
        }
    } else {
        echo "ACFの関数 'update_field' が見つかりませんでした。\n";
    }
}
