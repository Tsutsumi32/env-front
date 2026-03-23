<?php
/************************************************
 * アクリル製品の製造・加工コンテンツ
 * ※変数は画面側から受け取る
 *************************************************/
?>
<main class="ly_main">
    <div class="bl_secondPageHead __production">
        <?php require(get_theme_file_path('/inc//components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <div class="bl_secondPageHead_inner">
                <div class="bl_secondPageHead_headWrap">
                    <span class="bl_secondPageHead_sub">( <?php echo $head_contents['en'] ?> )</span>
                    <h1 class="bl_secondPageHead_head"><?php echo $head_contents['head'] ?></h1>
                </div>
                <div class="bl_secondPageHead_textWrap">
                    <p class="bl_secondPageHead_intro __noWrap"><?php echo $head_contents['intro'] ?></p>
                    <p class="bl_secondPageHead_text"><?php echo $head_contents['text'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="ly_flexContainer">
        <div class="ly_flexSide">
            <ul class="bl_anchorLink hp_noneSp">
                <?php foreach ($items as $index => $item): ?>
                    <li class="bl_anchorLink_item js_anchorLink<?php echo $index == 0 ? ' is_active' : null; ?>">
                        <a href="#section<?php echo $index + 1 ?>" class="bl_anchorLink_link"><?php echo $item['head'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- /.bl_anchorLink -->
        </div>
        <!-- /.ly_flexSide -->
        <div class="ly_flexInner">
            <section class="ly_section">
                <div class="ly_container">
                    <div class="bl_selectWrap hp_nonePc js_accordionParent">
                        <p class="bl_selectWrap_head">Category</p>
                        <button type="button" class="bl_selectWrap_btn js_selectText js_accordionBtn">
                            <?php echo $items[0]['head']; ?>
                        </button>
                        <ul class="bl_select js_accordionContents">
                            <?php foreach ($items as $index => $item): ?>
                                <li class="bl_select_item">
                                    <a href="#section<?php echo $index + 1 ?>"
                                        class="bl_select_link js_accordionItem js_selectTextItem"><?php echo $item['head'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- /.ly_section -->

            <?php foreach ($items as $index => $item): ?>
                <section class="bl_production js_anchorLinkTarget" id="section<?php echo $index + 1 ?>">
                    <div class="ly_container">
                        <div class="bl_production_headWrap">
                            <h2 class="bl_production_head"><?php echo $item['head'] ?></h2>
                            <span class="bl_production_number">( 0<?php echo $index + 1 ?> )</span>
                            <p class="bl_production_intro"><?php echo $item['intro'] ?></p>
                        </div>
                        <ul class="bl_cardList __col4">
                            <?php foreach ($item['lists'] as $list): ?>
                                <li class="bl_cardList_item">
                                    <p class="bl_cardList_head"><?php echo $list['head'] ?></p>
                                    <p class="bl_cardList_subHead"><?php echo $list['en'] ?></p>
                                    <p class="bl_cardList_text"><?php echo $list['text'] ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="bl_production_contentsWrap">
                            <h3 class="bl_production_contentsHead">主な製品</h3>
                            <ul class="bl_searchItemList __lowGap">
                                <?php
                                // 遷移前の画面から受け取ったprocessing_typeに一致する加工/施工製品を取得
                                $args = array(
                                    'post_type' => Post::PROCESSED_PRODUCTION,
                                    'orderby' => 'date',
                                    'order' => 'ASC',
                                    'meta_query' => array(
                                        array(
                                            'key' => AcfField::PROCESSED_PRODUCTION_PREFIX . 'processing_type',
                                            'value' => $item['processing_type'],
                                            'compare' => '='
                                        )
                                    )
                                );

                                $query = new WP_Query($args);

                                if ($query->have_posts()) :
                                    while ($query->have_posts()) : $query->the_post();
                                        $product_image = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'image1');
                                        $overview = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'overview');
                                        ?>
                                        <li class="bl_product">
                                            <a href="<?php echo get_permalink() . '?from=' . $current_page_slug; ?>" class="bl_product_link">
                                                <div class="bl_product_imgWrap __wide">
                                                    <?php if ($product_image && isset($product_image['url'])) : ?>
                                                        <img src="<?php echo esc_url($product_image['url']); ?>" alt="<?php echo esc_attr($product_image['alt'] ?? get_the_title()); ?>">
                                                    <?php else : ?>
                                                        <img src="<?php echo_img('noimage.jpg') ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <p class="bl_product_head"><?php the_title(); ?></p>
                                                <p class="bl_product_text __row2">
                                                    <?php echo esc_html($overview); ?>
                                                </p>
                                                <ul class="bl_labelUnit __small">
                                                    <?php
                                                    $selected_categories = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'category');
                                                    if ($selected_categories) {
                                                        foreach ($selected_categories as $category) {
                                                            echo '<li class="el_label __small">' . ListItems::getProductCategoryName($category) . '</li>';
                                                        };
                                                    };
                                                    $selected_mk_categories = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'mk_category');
                                                    if ($selected_mk_categories) {
                                                        foreach ($selected_mk_categories as $mk) {
                                                            echo '<li class="el_label __small">' . 'MK:' . ListItems::getProductMkCategoryName($mk) . '</li>';
                                                        };
                                                    };
                                                    $selected_tags = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'tag');
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
                                else : ?>
                                    <li class="bl_product">
                                        <p class="bl_product_text">現在準備中です。</p>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.ly_container -->
                </section>
                <!-- /.ly_section -->
            <?php endforeach; ?>
        </div>
        <!-- /.ly_flexInner -->
    </div>
</main>
<!-- /.ly_main -->