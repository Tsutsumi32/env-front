<?php
/**
 * 画像ファイルパスの取得
 *
 * @param string $path 以下のパス
 */
function get_img(string $path)
{
    return get_template_directory_uri() . '/assets/images/' . $path;
}
