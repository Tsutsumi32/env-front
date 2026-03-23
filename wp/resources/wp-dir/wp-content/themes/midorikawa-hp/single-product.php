<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
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
            <h1 class="bl_secondPageHead_products">
                <?php the_title(); ?>
            </h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="ly_section __ptSmall">
        <div class="ly_container">
            <div class="products_contents">
                <!-- 最大10枚の画像をスライダー表示 -->
                <div class="products_imgWrap">
                    <?php
                    $image_count = AcfField::PRODUCT_IMAGE_COUNT;
                    $has_images = false;
                    
                    // 画像が存在するかチェック
                    for ($i = 1; $i <= $image_count; $i++) {
                        $image = get_field("product_image{$i}");
                        if ($image && isset($image['url'])) {
                            $has_images = true;
                            break;
                        }
                    }
                    
                    if ($has_images) : ?>
                        <div class="products_imgSliderParent">
                            <div class="products_imgSlider swiper js_Slider">
                                <ul class="products_imgSliderWrapper swiper-wrapper">
                                    <?php
                                    for ($i = 1; $i <= $image_count; $i++) {
                                        $image = get_field("product_image{$i}");
                                        if ($image && isset($image['url'])) : ?>
                                            <li class="products_imgSliderSlide swiper-slide">
                                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? get_the_title()); ?>">
                                            </li>
                                        <?php endif;
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="products_imgSliderPagination js_pagination"></div>
                            <div class="products_imgSliderNav __prev js_prev"></div>
                            <div class="products_imgSliderNav __next js_next"></div>
                        </div>
                    <?php else : ?>
                        <!-- 画像がない場合のフォールバック -->
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/noimage.jpg" alt="画像がありません">
                    <?php endif; ?>
                </div>
                <div class="products_infoWrap">
                    <?php if (get_field('product_overview')) : ?>
                        <p class="products_infoWrap_head">製品の概要</p>
                        <p class="products_infoWrap_text">
                            <?php echo nl2br(auto_link_text(esc_html(get_field('product_overview')))); ?>
                        </p>
                    <?php endif; ?>
                    <?php
                    $contents_count = AcfField::PRODUCT_CONTENTS_COUNT;

                    // ループして、項目フィールドを表示
                    for ($i = 1; $i <= $contents_count; $i++) {
                        $title = get_field("product_contents{$i}_title");
                        $text = get_field("product_contents{$i}_text");

                        // タイトルが存在する場合に表示
                        if ($title) : ?>
                            <div class="products_infoWrap_exampleWrap">
                                <p class="products_infoWrap_example"><?php echo esc_html($title); ?></p>
                                <ul class="products_infoWrap_list">
                                    <li class="products_infoWrap_item">
                                        <!-- <p class="products_infoWrap_exampleHead">
                                        </p> -->
                                        <p class="products_infoWrap_exampleText">
                                            <?php echo nl2br(auto_link_text(esc_html($text))); ?>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                    <?php endif;
                    } ?>
                    <div class="bl_contactWrap">
                        <?php
                        $catalog_type = get_field('product_catalog_type');

                        if ($catalog_type === 'pdf') {
                            $file = get_field('product_pdf');
                            if ($file) : ?>
                                <a href="<?php echo esc_url($file['url']); ?>" download class="bl_contactWrap_download">製品カタログダウンロード</a>
                            <?php endif;
                        } elseif ($catalog_type === 'external') {
                            $external_url = get_field('product_external');
                            if ($external_url) : ?>
                                <a href="<?php echo esc_url($external_url); ?>" target="_blank" rel="noopener" class="bl_contactWrap_download">製品カタログダウンロード(外部サイト)</a>
                            <?php endif;
                        } elseif ($catalog_type === 'form') { ?>
                            <a href="<?php echo get_url(Page::CONTACT_DOWNLOAD, '', ['product_name' => get_the_title()]) ?>" class="bl_contactWrap_download">製品カタログダウンロード</a>
                        <?php } ?>
                        <div class="bl_contactWrap_inner">
                            <p class="bl_contactWrap_text">
                                <?php the_title(); ?>への<br class="hp_nonePc">
                                お問い合わせはこちら</p>
                            <a href="<?php echo get_url(Page::CONTACT, 'contact-form', ['product_name' => get_the_title()]) ?>" class="bl_contactWrap_btn">お問い合せ</a>
                        </div>
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