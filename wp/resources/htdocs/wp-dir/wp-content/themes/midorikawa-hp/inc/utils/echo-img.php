<?php
/**
 * 画像ファイルパスの出力
 *
 * @param string $path 以下のパス
 */
function echo_img(string $path)
{
    echo get_template_directory_uri() . '/assets/images/' . $path;
}
