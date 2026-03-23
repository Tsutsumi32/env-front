<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc//components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Business )</span>
            <h1 class="bl_secondPageHead_head">アクリルの総合商社</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <section class="ly_section __pB __ptSmall">
        <div class="ly_container">
            <div class="bl_head3 __pcCenter">
                <span class="bl_head3_sub">仕入れられる用品一覧</span>
                <h2 class="bl_head3_text">幅広い用途に対応する<br class="hp_noneSp">アクリル・プラスチック<br class="hp_nonePc">製品を一括調達</h2>
            </div>
            <div class="traiding_list">
                <ul class="bl_serviceUnit __traiding">
                    <li class="bl_service __traiding">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                アクリル板材・樹脂シート
                            </p>
                            <p class="bl_service_text">
                                透明・カラー・耐候性・耐衝撃・リサイクル対応品など
                            </p>
                        </div>
                    </li>
                    <li class="bl_service __traiding">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                成形用素材・原料
                            </p>
                            <p class="bl_service_text">
                                ペレット・樹脂粉末・押出・キャストアクリルなど
                            </p>
                        </div>
                    </li>
                    <li class="bl_service __traiding">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                加工・施工資材
                            </p>
                            <p class="bl_service_text">
                                接着剤・保護フィルム・各種表面処理剤など
                            </p>
                        </div>
                    </li>
                    <li class="bl_service __traiding">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                ディスプレイ・サイン関連
                            </p>
                            <p class="bl_service_text">
                                LED導光板・看板用アクリル・POP什器など
                            </p>
                        </div>
                    </li>
                    <li class="bl_service __traiding">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                建築・インテリア用アクリル
                            </p>
                            <p class="bl_service_text">
                                室内パネル・仕切り・手すりカバー・水槽など
                            </p>
                        </div>
                    </li>
                    <li class="bl_service __traiding">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                車両・産業機器用部材
                            </p>
                            <p class="bl_service_text">
                                計器バイザー・ウィンドウパネル・保護カバーなど
                            </p>
                        </div>
                    </li>
                    <li class="bl_service __traiding">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                リサイクル・環境配慮型アクリル
                                (自社開発製品)
                            </p>
                            <p class="bl_service_text">
                                再生アクリル板「リアライト®」・廃材回収対応
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <div class="ly_section __ptSmall">
        <div class="ly_container">
            <div class="bl_searchForm __pdLarge">
                <div class="bl_head3 __center">
                    <h2 class="bl_head3_text __noMt">製品検索</h2>
                </div>
                <form method="GET">
                    <div class="bl_searchForm_headWrap">
                        <p class="bl_searchForm_head __pcSmall">キーワード</p>
                        <div class="bl_searchKeyword">
                            <input type="text" name="keyword" placeholder="用途や製品名を入れてください。"
                                class="bl_searchKeyword_input __pcWide js_searchText" value="<?php echo isset($_GET['keyword']) ? esc_attr($_GET['keyword']) : ''; ?>">
                            <button type="submit" class="bl_searchKeyword_button js_loading">検　索</button>
                        </div>
                    </div>
                    <div class="bl_searchForm_tagList">
                        <p class="bl_searchForm_tagSubject">カテゴリー</p>
                        <div class="bl_searchForm_tagInner">
                            <?php foreach (ListItems::getProductCategories() as $key => $name): ?>
                                <input type="checkbox" class="bl_searchForm_cb js_searchCb" id="<?php echo 'cat' . $key ?>"
                                    name="product_categories[]" value="<?php echo $key; ?>" <?php echo (isset($_GET['product_categories']) && in_array($key, $_GET['product_categories'])) ? 'checked' : ''; ?>>
                                <label for="<?php echo 'cat' . $key ?>" class="el_label __lg"><?php echo $name; ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="bl_searchForm_tagList">
                        <p class="bl_searchForm_tagSubject">タグ</p>
                        <div class="bl_searchForm_tagInner">
                            <?php foreach (ListItems::getProductTags() as $key => $name): ?>
                                <input type="checkbox" class="bl_searchForm_cb js_searchCb" id="<?php echo 'tag' . $key ?>"
                                    name="product_tags[]" value="<?php echo $key; ?>" <?php echo (isset($_GET['product_tags']) && in_array($key, $_GET['product_tags'])) ? 'checked' : ''; ?>>
                                <label for="<?php echo 'tag' . $key ?>" class="el_label __lg"><?php echo '#' . $name; ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="bl_searchForm_button">
                        <button type="submit" class="el_btn __type2 __noIcon js_loading">この条件で検索する</button>
                    </div>
                    <button type="button" class="bl_searchForm_reset js_searchClear">条件をクリア</button>
                </form>
            </div>
            <!-- /.products_searchWrap -->
        </div>
        <!-- /.ly_container -->
    </div>
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 9,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged'          => $paged,
        'meta_query'     => array(
        ),
    );
    // keywordの検索条件を追加
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $args['s'] = sanitize_text_field($_GET['keyword']);
    }
    // product_categoriesの検索条件を追加
    if (isset($_GET['product_categories']) && !empty($_GET['product_categories'])) {
        $category_meta_query = array('relation' => 'OR');
        foreach ($_GET['product_categories'] as $cat) {
            $category_meta_query[] = array(
                'key'     => 'product_category',
                'value'   => '"' . $cat . '"',
                'compare' => 'LIKE',
            );
        }

        $args['meta_query'][] = $category_meta_query;
    }

    // product_tagsの検索条件を追加
    if (isset($_GET['product_tags']) && !empty($_GET['product_tags'])) {
        $tag_meta_query = array('relation' => 'OR');
        foreach ($_GET['product_tags'] as $tag) {
            $tag_meta_query[] = array(
                'key'     => 'product_tag',
                'value'   => '"' . $tag . '"',
                'compare' => 'LIKE',
            );
        }

        $args['meta_query'][] = $tag_meta_query;
    }
    if (count($args['meta_query']) > 1) {
        $args['meta_query']['relation'] = 'AND';  // 'AND' でつなげる
    }

    $query = new WP_Query($args);
    // 検索結果の総件数を取得
    $total_results = $query->found_posts;
    ?>
    <div class="ly_section js_searchResult">
        <div class="ly_container">
            <div class="bl_searchResultArea">
                <div class="bl_searchResultArea_resultWrap">
                    <div class="bl_searchResult">
                        <p class="bl_searchResult_head">検索結果 : <?php echo $total_results; ?>件</p>
                        <div class="bl_searchResult_labelWrap">
                            <p class="bl_searchResult_labelSubject hp_noneSp">キーワード</p>
                            <ul class="bl_searchResult_labelUnit">
                                <?php echo isset($_GET['keyword']) && !empty($_GET['keyword']) ? '<li class="el_label __lg">' . esc_attr($_GET['keyword']) . '</li>' : ''; ?>
                            </ul>
                        </div>
                        <div class="bl_searchResult_labelWrap">
                            <p class="bl_searchResult_labelSubject hp_noneSp">カテゴリー</p>
                            <ul class="bl_searchResult_labelUnit">
                                <?php
                                // URLのproduct_categoriesから選択されたタグを取得
                                $selected_categories = isset($_GET['product_categories']) ? $_GET['product_categories'] : [];

                                if ($selected_categories) {
                                    foreach ($selected_categories as $cat) {
                                        echo '<li class="el_label __lg">' . ListItems::getProductCategoryName($cat) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="bl_searchResult_labelWrap">
                            <p class="bl_searchResult_labelSubject hp_noneSp">タグ</p>
                            <ul class="bl_searchResult_labelUnit">
                                <?php
                                // URLのproduct_tagsから選択されたタグを取得
                                $selected_tags = isset($_GET['product_tags']) ? $_GET['product_tags'] : [];

                                if ($selected_tags) {
                                    foreach ($selected_tags as $tag) {
                                        echo '<li class="el_label __lg">' . '#' . ListItems::getProductTagName($tag) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bl_searchResultArea_itemWrap">
                    <ul class="bl_searchItemList">
                        <?php
                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post(); ?>
                                <li class="bl_product">
                                    <a href="<?php the_permalink(); ?>" class="bl_product_link">
                                        <div class="bl_product_imgWrap">
                                            <?php if (isset(get_field('product_image1')["url"])): ?>
                                                <img src="<?php echo get_field('product_image1')["url"] ?>" alt="">
                                            <?php else : ?>
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/noimage.jpg" alt="">
                                            <?php endif; ?>
                                        </div>
                                        <p class="bl_product_head"><?php the_title(); ?></p>
                                        <p class="bl_product_text">
                                            <?php echo nl2br(esc_html(get_field('product_overview'))); ?>
                                        </p>
                                        <ul class="bl_labelUnit __small">
                                            <?php
                                            $selected_categories = get_field('product_category');
                                            if ($selected_categories) {
                                                foreach ($selected_categories as $category) {
                                                    echo '<li class="el_label __small">' . ListItems::getProductCategoryName($category) . '</li>';
                                                };
                                            };
                                            $selected_mk_categories = get_field('product_mk_category');
                                            if ($selected_mk_categories) {
                                                foreach ($selected_mk_categories as $mk) {
                                                    echo '<li class="el_label __small">' . 'MK:' . ListItems::getProductMkCategoryName($mk) . '</li>';
                                                };
                                            };
                                            $selected_tags = get_field('product_tag');
                                            if ($selected_tags) {
                                                foreach ($selected_tags as $tag) {
                                                    echo '<li class="el_label __small">' . '#' . ListItems::getProductTagName($tag) . '</li>';
                                                };
                                            };
                                            ?>
                                        </ul>
                                    </a>
                                </li>
                        <?php endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </ul>
                    <div class="bl_pagination">
                        <?php
                        // ページネーションリンクを生成
                        the_pagination($query);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.ly_container -->
    </div>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>