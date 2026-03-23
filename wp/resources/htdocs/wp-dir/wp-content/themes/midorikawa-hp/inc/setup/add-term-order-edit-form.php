<?php
/***************************************************
    タームの編集画面に「順番」フィールドを追加
 ****************************************************/
add_action('admin_init', function () {
    if (!class_exists('Post')) return;

    $taxonomies = [];

    foreach (Post::getAll() as $key => $config) {
        $taxonomy = $config['category_settings']['slug'] ?? '';
        if (empty($taxonomy)) continue;

        $taxonomies[] = $taxonomy; // タクソノミーを収集

        // 編集画面にフィールドを追加
        /*
        add_action("{$taxonomy}_edit_form_fields", function ($term) {
            $order = get_term_meta($term->term_id, 'order', true);
            ?>
            <tr class="form-field">
                <th scope="row"><label for="term_order">順番 (order)</label></th>
                <td>
                    <input name="term_order" id="term_order" type="number" value="<?php echo esc_attr($order); ?>" />
                    <p class="description">表示順を決めるための数値です。</p>
                </td>
            </tr>
            <?php
        });*/

        // 保存処理
        /*
        add_action("edited_{$taxonomy}", function ($term_id) {
            if (isset($_POST['term_order'])) {
                update_term_meta($term_id, 'order', intval($_POST['term_order']));
            }
        });*/

        // 通常のソート機能を削除する
        add_filter("manage_edit-{$taxonomy}_sortable_columns", function ($columns) {
            // return しないことで、すべてのソートUIを無効にする
            return [];
        });

        // 新規作成時に order を自動設定
        add_action("created_{$taxonomy}", function ($term_id) use ($taxonomy) {
            // 既存タームの最大 order を取得
            $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
                'meta_key'   => 'order',
                'orderby'    => 'meta_value_num',
                'order'      => 'DESC',
                'number'     => 1,
            ]);

            $max_order = 0;
            if (!is_wp_error($terms) && !empty($terms)) {
                $max_order = intval(get_term_meta($terms[0]->term_id, 'order', true));
            }

            // 新しい順番を設定（最大値 + 1）
            update_term_meta($term_id, 'order', $max_order + 1);
        });

        // 一覧に順番を表示
        add_filter("manage_edit-{$taxonomy}_columns", function ($columns) {
            $columns['term_order'] = '順番';
            return $columns;
        });

        // 一覧の順番の横幅調整
        add_action('admin_head', function () use ($taxonomy) {
            $screen = get_current_screen();
            if (!$screen || $screen->taxonomy !== $taxonomy) return;

            echo '<style>
                th.column-term_order, td.column-term_order {
                    width: 50px;
                    text-align: center;
                }
            </style>';
        });

        // 一覧に順番の値を表示
        add_filter("manage_{$taxonomy}_custom_column", function ($out, $column_name, $term_id) {
            if ($column_name === 'term_order') {
                return esc_html(get_term_meta($term_id, 'order', true));
            }
            return $out;
        }, 10, 3);
    }
});
