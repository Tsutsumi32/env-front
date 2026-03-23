<?php
/***************************************************
    contactform7 バリデーション　カスタム
 ****************************************************/
function cft_validate_input($result, $tag)
{
    $tag = new WPCF7_FormTag($tag);

    // 担当者名
    if ('your-name' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "担当者名は必須項目です。入力してください。");
        } elseif (mb_strlen($value) > 60) {
            $result->invalidate($tag, "担当者名は60文字以内で入力してください。");
        }
    }

    // ふりがな
    if ('your-furigana' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "フリガナは必須項目です。入力してください。");
        } elseif (mb_strlen($value) > 60) {
            $result->invalidate($tag, "フリガナは60文字以内で入力してください。");
        } elseif (!preg_match('/^[ぁ-んー　]+$/u', $value)) {
            $result->invalidate($tag, '全角ひらがなで入力してください。');
        }
    }

    // 会社名
    if ('your-company' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "会社名は必須項目です。入力してください。");
        } elseif (mb_strlen($value) > 60) {
            $result->invalidate($tag, "会社名は60文字以内で入力してください。");
        }
    }

    // 部署・役職名
    if ('your-belong' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "担部署・役職名は必須項目です。入力してください。");
        } elseif (mb_strlen($value) > 60) {
            $result->invalidate($tag, "部署・役職名は60文字以内で入力してください。");
        }
    }

    // メールアドレス
    if ('your-email' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "メールアドレスは必須項目です。入力してください。");
        } elseif (!is_email($value)) {
            $result->invalidate($tag, "正しいメールアドレスを入力してください。");
        }
    }

    // 電話番号
    if ('your-tel' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "電話番号は必須項目です。入力してください。");
        } elseif (!preg_match('/^(\d{2,4}-?\d{2,4}-?\d{4})$/', $value)) {
            $result->invalidate($tag, "電話番号を入力してください。");
        }
    }

    // FAX番号
    if ('your-tel' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "FAX番号は必須項目です。入力してください。");
        } elseif (!preg_match('/^(\d{2,4}-?\d{2,4}-?\d{4})$/', $value)) {
            $result->invalidate($tag, "FAX番号を入力してください。");
        }
    }

    return $result;
}
add_filter('wpcf7_validate_text', 'cft_validate_input', 20, 2);

// お問合せ内容
function cft_validate_content($result, $tag)
{
    $tag = new WPCF7_FormTag($tag);

    if ('your-message' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, "内容の詳細は必須項目です。入力してください。");
        } elseif (mb_strlen($value) > 1000) {
            $result->invalidate($tag, "内容の詳細は1000文字以内で入力してください。");
        }
    }
    return $result;
}
add_filter('wpcf7_validate_textarea', 'cft_validate_content', 20, 2);

function cft_validate_select($result, $tag)
{
    $tag = new WPCF7_FormTag($tag);
    $name = $tag->name;

    // ... 既存のテキスト・電話番号などのチェック ...

    // ▼ セレクトボックスの必須チェック
    if ($name === 'your-subject') {
        $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
        if (empty($value)) {
            $result->invalidate($tag, '選択項目は必須です。選択してください。');
        }
    }

    return $result;
}
add_filter('wpcf7_validate_select', 'cft_validate_select', 20, 2);

// カスタムバリデーション関数の定義（チェックボックスフィールド）
function cft_validate_acceptance($result, $tag)
{
    $tag = new WPCF7_FormTag($tag);

    if ('agree' == $tag->name) {
        $value = isset($_POST[$tag->name]) ? $_POST[$tag->name] : '';

        if (empty($value)) {
            $result->invalidate($tag, "個人情報の取り扱いについて同意が必要です。");
        }
    }

    return $result;
}

add_filter('wpcf7_validate_checkbox', 'cft_validate_acceptance', 20, 2);
