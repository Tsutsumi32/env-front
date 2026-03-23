<?php
/**
 * テキスト内のURLを自動的にリンク化する
 *
 * @param string $text リンク化するテキスト
 * @return string
 */
function auto_link_text(string $text): string
{
    // URLパターンを検出（http/httpsで始まるURL）
    $pattern = '/(https?:\/\/[^\s<>"{}|\\^`\[\]]+)/i';
    
    // デフォルト属性を設定
    $attributes = [
        'target' => '_blank',
        'rel' => 'noopener'
    ];
    
    // 属性をHTML文字列に変換
    $attr_string = '';
    foreach ($attributes as $key => $value) {
        $attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
    }
    
    // URLをリンクに変換
    $replacement = '<a class="el_link" href="$1"' . $attr_string . '><i class="fa-solid fa-arrow-up-right-from-square"></i>LINK</a>';
    $linked_text = preg_replace($pattern, $replacement, $text);
    
    return $linked_text;
}
