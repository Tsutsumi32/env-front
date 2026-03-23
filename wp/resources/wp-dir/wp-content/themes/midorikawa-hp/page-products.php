<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead __type2">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Product )</span>
            <h1 class="bl_secondPageHead_head">製品紹介</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="ly_section __ptSmall __pB">
        <div class="ly_container">
            <div class="bl_searchForm">
                <form method="GET">
                    <div class="bl_searchForm_headWrap">
                        <p class="bl_searchForm_head">全てのMKブランド製品カテゴリー</p>
                        <div class="bl_searchKeyword">
                            <input type="text" name="keyword" placeholder="キーワード検索" class="bl_searchKeyword_input" value="<?php echo isset($_GET['keyword']) ? esc_attr($_GET['keyword']) : ''; ?>">
                            <button type="submit" class="bl_searchKeyword_button js_loading">検　索</button>
                        </div>
                    </div>
                    <div class="bl_searchForm_categoryList">
                        <?php foreach (ListItems::getProductMkCategories() as $key => $name): ?>
                            <label class="bl_searchForm_category">
                                <input class="bl_searchForm_cb" type="checkbox" name="product_mk_categories[]" value="<?php echo $key; ?>"
                                    <?php echo (isset($_GET['product_mk_categories']) && in_array($key, $_GET['product_mk_categories'])) ? 'checked' : ''; ?>>
                                <?php echo $name; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </form>
            </div>
            <!-- /.products_searchWrap -->
        </div>
        <!-- /.ly_container -->
    </div>

    <section class="ly_section __color">
        <div class="ly_container __mx922">
            <div class="bl_head2 __center">
                <span class="bl_head2_sub">おすすめ製品</span>
                <h3 class="bl_head2_text">PICK UP</h3>
            </div>
            <ul class="products_pickup">
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                    'order' => 'DESC',
                    'meta_query'     => array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'product_pickup',
                            'value'   => '1',
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key'     => 'product_category',
                            'value'   => '"1"',
                            'compare' => 'LIKE',
                        ),
                    ),
                );
                $pickup_query = new WP_Query($args);
                if ($pickup_query->have_posts()) :
                    while ($pickup_query->have_posts()) : $pickup_query->the_post(); ?>
                        <li class="bl_product">
                            <a href="<?php the_permalink(); ?>" class="bl_product_link">
                                <div class="bl_product_imgWrap">
                                    <span class="bl_product_pick">PICK UP！</span>
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
                                            echo '<li class="el_label __small __white">' . ListItems::getProductCategoryName($category) . '</li>';
                                        };
                                    };
                                    $selected_mk_categories = get_field('product_mk_category');
                                    if ($selected_mk_categories) {
                                        foreach ($selected_mk_categories as $mk) {
                                            echo '<li class="el_label __small __white">' . 'MK:' . ListItems::getProductMkCategoryName($mk) . '</li>';
                                        };
                                    };
                                    $selected_tags = get_field('product_tag');
                                    if ($selected_tags) {
                                        foreach ($selected_tags as $tag) {
                                            echo '<li class="el_label __small __white">' . '#' . ListItems::getProductTagName($tag) . '</li>';
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
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 9,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged'          => $paged,
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'product_category',
                'value'   => '"1"',
                'compare' => 'LIKE',
            ),
        ),
    );
    // keywordの検索条件を追加
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $args['s'] = sanitize_text_field($_GET['keyword']);
    }
    // product_mk_categoriesの検索条件を追加
    if (isset($_GET['product_mk_categories']) && !empty($_GET['product_mk_categories'])) {
        // 既存のmeta_queryを保持
        $existing_meta_query = $args['meta_query'];
        
        // 新しいmeta_queryを作成
        $new_meta_query = array('relation' => 'OR');

        foreach ($_GET['product_mk_categories'] as $mk) {
            $new_meta_query[] = array(
                'key'     => 'product_mk_category',
                'value'   => '"' . $mk . '"',
                'compare' => 'LIKE',
            );
        }

        // 既存の条件と新しい条件を結合
        $args['meta_query'] = array(
            'relation' => 'AND',
            $existing_meta_query,
            $new_meta_query
        );
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
                                <li class="el_label __lg">MKブランド製品</li>
                            </ul>
                        </div>
                        <div class="bl_searchResult_labelWrap">
                            <p class="bl_searchResult_labelSubject hp_noneSp">MKブランド製品カテゴリー</p>
                            <ul class="bl_searchResult_labelUnit">
                                <?php
                                // URLのproduct_mk_categoriesから選択されたタグを取得
                                $selected_mk_categories = isset($_GET['product_mk_categories']) ? $_GET['product_mk_categories'] : [];

                                if ($selected_mk_categories) {
                                    foreach ($selected_mk_categories as $mk) {
                                        echo '<li class="el_label __lg">' . ListItems::getProductMkCategoryName($mk) . '</li>';
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