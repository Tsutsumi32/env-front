<?php

/***************************************************
    ACF設定
 ****************************************************/
function set_acf_settings($acf_items)
{
    foreach ($acf_items as $acf_item) {
        //var_dump($acf_item);
        $setting = $acf_item['slug'];
        $label = $acf_item['label'];
        $name = $acf_item['slug'];
        $type = !empty($acf_item['type']) ? $acf_item['type'] : 'text';
        $instruction = !empty($acf_item['instruction']) ? $acf_item['instruction'] : '';
        $required = !empty($acf_item['required']) ? $acf_item['required'] : 0;
        $default_value = !empty($acf_item['default_value']) ? $acf_item['default_value'] : '';
        $placeholder = !empty($acf_item['placeholder']) ? $acf_item['placeholder'] : '';
        $choices = !empty($acf_item['choices']) ? $acf_item['choices'] : '';
        $conditional_logic = !empty($acf_item['conditional_logic']) ? $acf_item['conditional_logic'] : '';
        $allow_null = !empty($acf_item['allow_null']) ? $acf_item['allow_null'] : 1;
        $multiple = !empty($acf_item['multiple']) ? $acf_item['multiple'] : 0;
        $mime_types = !empty($acf_item['mime_types']) ? $acf_item['mime_types'] : '';
        $acf_settings[] = [
            'key' => $setting, // フィールドのキー（ユニークな文字列）
            'label' => $label, // フィールドのラベル
            'name' => $name, // フィールドの名前（投稿メタデータのキーとして保存）
            'type' => $type, // フィールドタイプ（例: text, number, selectなど）
            'instructions' => $instruction, // ユーザー向け説明
            'choices' => $choices,
            'required' => $required, // 必須の場合は1
            'default_value' => $default_value, // デフォルト値
            'placeholder' => $placeholder, // プレースホルダー
            'allow_null' => $allow_null, // 空許容
            'multiple' => $multiple, // 複数選択
            'conditional_logic' => $conditional_logic, // 表示・非表示のロジック
            'mime_types' => $mime_types, // ファイル形式
        ];
    };
    return $acf_settings;
}

// ACF設定 セットアップ
foreach (AcfField::getAllSettings() as $setting) {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => $setting['slug'], // フィールドグループのキー（ユニークな文字列）
            'title' => $setting['label'], // フィールドグループのタイトル
            'fields' => set_acf_settings($setting['items']),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type', // 条件（投稿タイプ）
                        'operator' => '==', // 条件の比較
                        'value' => $setting['post_type'], // 対象の投稿タイプ（例: post, page, カスタム投稿タイプ名など）
                    ),
                ),
            ),
        ));
    }
}
