<?php
/************************************************
 * タイトル出力
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
?>
<title><?php echo $title ?></title>