<?php
/**
 * テーマカラー出力
 * 
 * このファイルでは、theme-colorメタタグを出力します。
 */
?>
<meta name="theme-color" content="<?php echo htmlspecialchars(
    THEME_COLOR,
    ENT_QUOTES,
    'UTF-8',
); ?>">

