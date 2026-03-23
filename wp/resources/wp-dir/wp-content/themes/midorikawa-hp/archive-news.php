<?php
if (!defined('ABSPATH')) exit;
get_header();

// カテゴリのリストを取得
$categories = get_terms('news-category');
usort($categories, function ($a, $b) {
    $order_a = get_term_meta($a->term_id, 'order', true);
    $order_b = get_term_meta($b->term_id, 'order', true);
    return intval($order_a) - intval($order_b);
});
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc//components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( NEWS )</span>
            <h1 class="bl_secondPageHead_head">お知らせ</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->
    <div class="ly_section">
        <div class="ly_container">
            <div class="news_area">
                <div class="news_category hp_noneSp">
                    <div class="news_category_inner">
                        <p class="news_category_head">カテゴリー</p>
                        <ul class="news_category_list">
                            <li class="news_category_item <?php echo (!isset($_GET['category']) ? ' is_active' : '') ?>">
                                <a href="<?php echo esc_url(remove_query_arg('category')) ?>" class="news_category_link <?php echo (!isset($_GET['category']) ? ' is_active' : '') ?>">全て</a>
                            </li>
                            <?php
                            foreach ($categories as $category) :
                                $category_link = add_query_arg(array('category' => $category->term_id, 'paged' => 1));
                            ?>
                                <li class="news_category_item <?php echo (isset($_GET['category']) && $_GET['category'] == $category->term_id ? ' is_active' : '') ?>">
                                    <a href="<?php echo $category_link ?>" class="news_category_link <?php echo (isset($_GET['category']) && $_GET['category'] == $category->term_id ? ' is_active' : '') ?>">
                                        <?php echo esc_html($category->name) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="bl_selectWrap hp_nonePc js_accordionParent">
                    <p class="bl_selectWrap_head">Category</p>
                    <button type="button" class="bl_selectWrap_btn js_selectText js_accordionBtn">
                        <?php
                        $category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;

                        if ($category_id > 0) {
                            $category = get_term($category_id, 'news-category');
                            echo esc_html($category->name);
                        } else {
                            echo '全て';
                        }
                        ?>
                    </button>
                    <ul class="bl_select js_accordionContents">
                        <li class="bl_select_item">
                            <a href="<?php echo esc_url(remove_query_arg('category')) ?>" class="bl_select_link">全て</a>
                        </li>
                        <?php
                        foreach ($categories as $category) :
                            $category_link = add_query_arg(array('category' => $category->term_id, 'paged' => 1));
                        ?>
                            <li class="bl_select_item">
                                <a href="<?php echo $category_link ?>" class="bl_select_link">
                                    <?php echo esc_html($category->name) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="news_article">
                    <ul class="bl_news">
                        <?php
                        // 現在のカテゴリIDを取得
                        $category_id = isset($_GET['category']) ? $_GET['category'] : '';

                        // $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        if (isset($_GET['keyword']) || isset($_GET['product_tag'])) {
                            $paged = 1; // 検索時にページングを1にリセット
                        } else {
                            // 通常のページング
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        }
                        $args = array(
                            'post_type' => 'news',
                            'posts_per_page' => 10,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'meta_query' => array(),
                            'paged' => $paged,
                        );
                        // カテゴリで絞り込む
                        if ($category_id) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'news-category',  // タクソノミー名
                                    'field' => 'id',
                                    'terms' => $category_id,  // 指定されたカテゴリID
                                    'operator' => 'IN',
                                ),
                            );
                        }
                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post();
                                // カテゴリ取得
                                $terms = get_the_terms(get_the_ID(), 'news-category');
                                $categories = '';
                                if ($terms && !is_wp_error($terms)) {
                                    foreach ($terms as $term) {
                                        $categories = $categories . '<span class="bl_newsInfo_category">' . $term->name . '</span>';
                                    }
                                };
                        ?>
                                <li class="bl_news_item">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="bl_news_imgWrap">
                                            <img src="<?php echo esc_url(get_field('news_image')['url']) ?>" alt="">
                                        </div>
                                        <div class="bl_news_inner">
                                            <div class="bl_news_textWrap">
                                                <div class="bl_newsInfo">
                                                    <span class="bl_newsInfo_date"><?php echo get_the_date('Y.m.d'); ?></span>
                                                    <?php echo $categories ?>
                                                </div>
                                                <p class="bl_news_text">
                                                    <?php echo esc_html(get_the_title()); ?>
                                                </p>
                                            </div>
                                            <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="" class="bl_news_icon">
                                        </div>
                                    </a>
                                </li>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </ul>
                    <?php the_pagination($query); ?>
                </div>
            </div>
        </div>
        <!-- /.ly_container -->
    </div>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>