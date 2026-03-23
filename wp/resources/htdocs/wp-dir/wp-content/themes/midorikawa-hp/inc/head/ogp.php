<?php
/************************************************
 * OGPの出力
 *************************************************/
// タイトル
$prefix = SITE_NAME;
$title =  Page::getTitle(get_current_slug());
if (empty($title)) {
    $title = Post::getTitle(get_current_slug());
}
if (is_single()) {
    $title =  get_the_title();
}

if (is_home() ||is_front_page()) {
    $title = $prefix;
} else {
    $title = $title . ' | ' . $prefix;
}

// ディスクリプション
$description =  Page::getDescription(get_current_slug());
if(empty($description)) {
    $description = Post::getDescription(get_current_slug());
}
if(is_single()) {
    $description = get_the_excerpt();
}
?>
<meta property="og:title" content="<?php echo $title; ?>">
<meta property="og:description" content="<?php echo $description; ?>">
<meta property="og:image" content="<?php echo_img('setting/ogp.png') ?>">
<?php if (is_single()): ?>
    <meta property="og:type" content="article">
<?php else: ?>
    <meta property="og:type" content="website">
<?php endif; ?>
<meta property="og:url" content="<?php echo get_pagenum_link(); ?>">
<meta property="og:site_name" content="<?php echo SITE_NAME ?>">