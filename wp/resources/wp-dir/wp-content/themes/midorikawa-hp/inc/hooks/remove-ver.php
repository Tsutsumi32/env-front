<?php
/***************************************************
    バージョン出力の削除
 ****************************************************/
function remove_ver($src)
{
    if (strpos($src, 'ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}
add_filter('style_loader_src', 'remove_ver', 9999);
add_filter('script_loader_src', 'remove_ver', 9999);
