<?php
/**
 * 動画ファイルパスの出力
 *
 * @param string $path 以下のパス
 */
function echo_video(string $path)
{
    echo get_template_directory_uri() . '/assets/videos/' . $path;
}
