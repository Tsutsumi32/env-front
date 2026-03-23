<?php
if (!defined('ABSPATH')) exit;
get_header();
?>

<div class="top_first js_first">
    <div class="top_first_bg"></div>
    <div class="top_first_logo js_firstLogo">
        <img src="<?php echo_img('logo.png') ?>" alt="">
    </div>
</div>

<main class="ly_main __top">
    <div class="top_mv js_mv">
        <div class="top_mv_inner js_firstContents">
            <p class="top_mv_text">Shaping the Future with Innovation</p>
            <h1 class="top_mv_head">期待を超える<span>技術</span>で<br class="hp_nonePc">新しい<span>未来</span>を創る</h1>
            <div class="top_mv_list">
                <p class="top_mv_item">アクリル製品開発、製造・加工
                </p>
                <p class="top_mv_item">アクリル板材・資材
                </p>
                <p class="top_mv_item">再生アクリル原料の販売</p>
            </div>
        </div>
        <!-- /.top_mv_inner -->
        <?php
        $args = array(
            'post_type' => 'news',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => array(),
        );
        $query_latest_1 = new WP_Query($args);
        if ($query_latest_1->have_posts()) :
            $query_latest_1->the_post();
        ?>
            <a href="<?php the_permalink(); ?>" class="top_mv_news js_firstContents">
                <div class="top_mv_news_inner">
                    <div class="top_mv_news_textWrap">
                        <p class="top_mv_news_head">NEWS</p>
                        <p class="top_mv_news_text"><?php echo esc_html(get_the_title()); ?></p>
                    </div>
                    <span class="top_mv_news_icon">
                        <img src="<?php echo_img('icon_arow_right_white.svg') ?>" alt="">
                    </span>
                </div>
                <!-- /.ly_container -->
            </a>
        <?php
        endif;
        wp_reset_postdata();
        ?>
        <div class="top_mv_sliderParent js_mvSlider swiper">
            <ul class="top_mv_slider swiper-wrapper">
                <li class="top_mv_slide swiper-slide">
                    <img src="<?php echo_img('top_img_mv1.jpg') ?>" alt="">
                </li>
                <li class="top_mv_slide swiper-slide">
                    <img src="<?php echo_img('top_img_mv2.jpg') ?>" alt="">
                </li>
                <li class="top_mv_slide swiper-slide">
                    <img src="<?php echo_img('top_img_mv3.jpg') ?>" alt="">
                </li>
            </ul>
            <div class="top_mv_sliderPagination swiper-pagination js_pagination"></div>
        </div>
    </div>
    <!-- /.top_mv -->

    <section class="ly_section __ptLarge">
        <div class="ly_container __mx917">
            <div class="bl_head __center">
                <span class="bl_head_sub">( Our Business )</span>
                <h2 class="bl_head_text __large">緑川化成の<span>事業</span></h2>
            </div>
            <div class="top_service">
                <ul class="bl_serviceUnit js_anime_transUp">
                    <li class="bl_service">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                アクリル製品の<br>
                                企画・開発
                            </p>
                            <p class="bl_service_text">
                                高透明・高耐久のアクリル製品を企画・開発しています。<br>
                                用途や時代に応じた加工技術とリサイクル技術を活かし、持続可能な製品開発に取り組んでいます。
                            </p>
                        </div>
                    </li>
                    <li class="bl_service">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                アクリルの<br>
                                総合商社
                            </p>
                            <p class="bl_service_text">
                                国内屈指のアクリル総合商社として、アクリル・塩ビ・ポリカ・PETなどのプラスチック素材やエンジニアリングプラスチック、成形用ペレット、ステンレス、木材など、多様な素材や部材を取り扱っています。
                            </p>
                        </div>
                    </li>
                    <li class="bl_service">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                アクリル製品の<br>
                                製造・加工
                            </p>
                            <p class="bl_service_text">
                                アクリル製品の製造・加工を手掛け、再生アクリル「リアライト®」を活用した環境配慮型製品を提供。<br>
                                設計から施工まで一貫対応し、ニーズに応じたカスタマイズにも対応しています。
                            </p>
                        </div>
                    </li>
                    <li class="bl_service">
                        <div class="bl_service_inner">
                            <p class="bl_service_head">
                                アクリル製品の<br>
                                リサイクル
                            </p>
                            <p class="bl_service_text">
                                使用済みアクリル製品を回収し、分別・洗浄・粉砕などの工程を経て再資源化することで、廃棄物の削減と資源の有効活用を推進し、循環型社会の実現に貢献しています。
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <div class="top_aboutParent">
        <section class="ly_section">
            <div class="ly_container __mx1028">
                <div class="bl_head">
                    <span class="bl_head_sub">( About Us )</span>
                    <h2 class="bl_head_text __pcLarge">「ほしい」を、<span>カタチ</span>に。</h2>
                </div>
                <div class="top_about">
                    <div class="top_about_imgWrap">
                        <img src="<?php echo_img('top_img_about1.jpg') ?>" alt="" class="js_anime_transUp">
                        <img src="<?php echo_img('top_img_about2.jpg') ?>" alt="" class="js_anime_transUp">
                        <img src="<?php echo_img('top_img_about3.jpg') ?>" alt="" class="js_anime_transUp">
                    </div>
                    <p class="top_about_text js_anime_transUp">
                        私たち緑川化成工業は循環型社会を創り上げる素材と技術のメーカーとして、アクリル・プラスチック製品を中心に、リサイクル材料など、次世代を見据えた製品を開発・提供しています。<br><br>
                        日本の育んできた思いやりある心と革新的な技術を兼ね備えた企業として、お客様の「ほしい」をカタチにし、　未来を切り拓いていきます。
                    </p>
                </div>
            </div>
            <!-- /.ly_container -->
        </section>
        <!-- /.ly_section -->
    </div>

    <div class="top_gragient">
        <section class="ly_section">
            <div class="ly_container __left __spMax">
                <div class="top_headWrap">
                    <div class="bl_head __noPcMb">
                        <span class="bl_head_sub">( Product )</span>
                        <h2 class="bl_head_text">主力製品紹介</h2>
                    </div>
                    <p class="top_productIntro">
                        私たちの製品は、幅広い分野で活用され、お客様の多様なニーズに応えることで、より良い未来を創造しています。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTS); ?>" class="el_btn __type2 hp_noneSpFlex">製品一覧</a>
                </div>
                <div class="top_productSliderParent">
                    <div class="top_productSlider js_productSlider swiper js_anime_transUp">
                        <ul class="top_productSlider_wrapper swiper-wrapper">
                            <?php
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => 4,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'paged' => $paged,
                                'meta_query' => array(
                                )
                            );

                            $query = new WP_Query($args);

                            if ($query->have_posts()) :
                                while ($query->have_posts()) : $query->the_post(); ?>

                                    <li class="top_productSlider_slide swiper-slide">
                                        <a href="<?php the_permalink(); ?>" class="top_productSlider_link">
                                            <?php
                                            $product_image = get_field('product_image1');
                                            if ($product_image && isset($product_image['url'])) : ?>
                                                <img src="<?php echo esc_url($product_image['url']); ?>" alt="<?php echo esc_attr($product_image['alt'] ?? get_the_title()); ?>" class="top_productSlider_img">
                                            <?php else : ?>
                                                <img src="<?php echo_img('noimage.jpg') ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="top_productSlider_img">
                                            <?php endif; ?>
                                            <p class="top_productSlider_head"><?php the_title(); ?></p>
                                            <p class="top_productSlider_text">
                                                <?php echo nl2br(esc_html(get_field('product_overview'))); ?>
                                            </p>
                                            <ul class="bl_labelUnit">
                                                <?php
                                                $selected_categories = get_field('product_category');
                                                if ($selected_categories) {
                                                    foreach ($selected_categories as $category) {
                                                        echo '<li class="el_label">' . ListItems::getProductCategoryName($category) . '</li>';
                                                    };
                                                };
                                                $selected_mk_categories = get_field('product_mk_category');
                                                if ($selected_mk_categories) {
                                                    foreach ($selected_mk_categories as $mk) {
                                                        echo '<li class="el_label">' . 'MK:' . ListItems::getProductMkCategoryName($mk) . '</li>';
                                                    };
                                                };
                                                $selected_tags = get_field('product_tag');
                                                if ($selected_tags) {
                                                    foreach ($selected_tags as $tag) {
                                                        echo '<li class="el_label">' . '#' . ListItems::getProductTagName($tag) . '</li>';
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
                    <div class="el_sliderBtn __prev js_prev">
                        <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="前へ">
                    </div>
                    <div class="el_sliderBtn __next js_next">
                        <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="次へ">
                    </div>
                </div>
                <div class="top_productBtn">
                    <a href="<?php echo get_url(Page::PRODUCTS); ?>" class="el_btn __type2 hp_nonePc">製品一覧</a>
                </div>
            </div>
        </section>
        <!-- /.ly_section -->
    </div>

    <section class="ly_section">
        <div class="top_company">
            <div class="top_company_inner">
                <div class="top_company_contents">
                    <div class="top_company_textWrap">
                        <div class="bl_head __white __spCenter">
                            <span class="bl_head_sub">( Company )</span>
                            <h2 class="bl_head_text">会社情報</h2>
                        </div>
                        <p class="top_company_text">
                            広い視野と温かい心で未来を創る――<br>
                            経営理念「大きな心と大調和」に基づく、<br>
                            緑川化成工業の想いとあゆみをご紹介します。
                        </p>
                    </div>
                    <div class="top_company_btnWrap">
                        <a href="<?php echo get_url(Page::COMPANY); ?>" class="el_btn __type2 __white">会社情報</a>
                    </div>
                </div>
                <div class="top_company_sliderParent">
                    <div class="top_company_slider swiper js_companySlider">
                        <ul class="top_company_sliderWrap swiper-wrapper">
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide1.jpg') ?>" alt="">
                            </li>
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide2.jpg') ?>" alt="">
                            </li>
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide3.jpg') ?>" alt="">
                            </li>
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide4.jpg') ?>" alt="">
                            </li>
                        </ul>
                    </div>
                    <div class="top_company_slider swiper js_companySlider_reverse">
                        <ul class="top_company_sliderWrap swiper-wrapper">
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide5.jpg') ?>" alt="">
                            </li>
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide6.jpg') ?>" alt="">
                            </li>
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide7.jpg') ?>" alt="">
                            </li>
                            <li class="top_company_slide swiper-slide">
                                <img src="<?php echo_img('top_img_company_slide8.jpg') ?>" alt="">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.ly_section -->

    <section class="ly_section">
        <div class="ly_container">
            <div class="top_newsWrap">
                <div class="top_newsWrap_headWrap">
                    <div class="bl_head">
                        <span class="bl_head_sub">( NEWS )</span>
                        <h2 class="bl_head_text">新着情報</h2>
                    </div>
                    <a href="<?php echo get_url(Post::NEWS); ?>" class="el_btn __type2 hp_noneSpFlex">お知らせ一覧</a>
                </div>
                <div class="top_newsWrap_articleWrap">
                    <ul class="bl_news">
                        <?php
                        // 最新の3件の投稿を取得
                        $args = array(
                            'post_type' => 'news',
                            'posts_per_page' => 3,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        );
                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post(); ?>
                                <li class="bl_news_item">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="bl_news_imgWrap">
                                            <img src="<?php echo esc_url(get_field('news_image')['url']) ?>" alt="">
                                        </div>
                                        <div class="bl_news_inner">
                                            <div class="bl_news_textWrap">
                                                <div class="bl_newsInfo">
                                                    <span class="bl_newsInfo_date"><?php echo get_the_date('Y.m.d'); ?></span>
                                                    <span class="bl_newsInfo_category"><?php echo get_post_type(); ?></span>
                                                </div>
                                                <p class="bl_news_text">
                                                    <?php echo get_the_title(); ?>
                                                </p>
                                            </div>
                                            <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="" class="bl_news_icon">
                                        </div>
                                    </a>
                                </li>
                            <?php
                            endwhile;
                            wp_reset_postdata(); ?>
                        <?php else : ?>
                            <li>ニュースがありません</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <a href="<?php echo get_url(Post::NEWS); ?>" class="el_btn __type2 __wide hp_nonePc">お知らせ一覧</a>
            </div>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>