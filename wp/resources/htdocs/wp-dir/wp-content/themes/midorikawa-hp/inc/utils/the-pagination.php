<?php
/***************************************************
    共通ページネーション()
 ****************************************************/
function the_pagination($query)
{
    $big = 999999999;
    $current = max(1, get_query_var('paged'));
    $total = $query->max_num_pages;

    if ($total <= 1) return;

    // 現在のURLのクエリパラメータを取得
    $url_params = $_GET;

    // 現在のURLのページ番号（paged）を除外して、新しいページリンクに追加
    if (isset($url_params['paged'])) {
        unset($url_params['paged']);
    }

    // 前へ・次へボタン
    $prev_disabled = ($current <= 1) ? ' is_disabled' : '';
    $next_disabled = ($current >= $total) ? ' is_disabled' : '';

    $prev_link = ($current > 1)
        ? add_query_arg(array_merge($url_params, array('paged' => $current - 1)))
        : '#';

    $next_link = ($current < $total)
        ? add_query_arg(array_merge($url_params, array('paged' => $current + 1)))
        : '#';

    echo '<div class="bl_pagination">';

    // 前へボタン
    echo '<a class="bl_pagination_button __prev' . $prev_disabled . '" href="' . esc_url($prev_link) . '"></a>';

    // 中央のページリンク部分のみ paginate_links() に任せる
    echo paginate_links(array(
        'base'      => str_replace($big, '%#%', add_query_arg(array_merge($url_params, array('paged' => '%#%')))),
        'total'     => $total,
        'current'   => $current,
        'format'    => '',
        'type'      => 'list',
        'end_size'  => 1,
        'mid_size'  => 1,
        'prev_next' => false, // 前・次は自分で出力するため無効に
    ));

    // 次へボタン
    echo '<a class="bl_pagination_button __next' . $next_disabled . '" href="' . esc_url($next_link) . '"></a>';

    echo '</div>';
}