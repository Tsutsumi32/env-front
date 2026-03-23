<?php
if (!defined('ABSPATH')) exit;

// パンくず情報を上書きする
$override_bred = [
    Page::PRODUCTION,
    isset($_GET['from']) ? $_GET['from'] : get_current_slug(),
];

get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
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
                    $image_count = AcfField::PROCESSED_PRODUCTION_IMAGE_COUNT;
                    $has_images = false;

                    // 画像が存在するかチェック
                    for ($i = 1; $i <= $image_count; $i++) {
                        $image = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . "image{$i}");
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
                                        $image = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . "image{$i}");
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
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/noimage.jpg" alt="画像がありません">
                    <?php endif; ?>
                </div>
                <div class="products_infoWrap">
                    <h2 class="products_secondHead"><?php echo get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'overview_title'); ?></h2>
                    <p class="products_text"><?php echo nl2br(auto_link_text(esc_html(get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'overview')))); ?></p>
                    <?php
                    for ($i = 1; $i <= AcfField::PRODUCT_PROCESSING_CONTENTS_COUNT; $i++) {
                        $title = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . "contents{$i}_title");
                    ?>
                        <p class="products_infoWrap_head"><?php echo esc_html($title); ?></p>
                        <ul class="products_outline">
                            <?php
                            for ($j = 1; $j <= AcfField::PRODUCT_PROCESSING_CONTENTS_COUNT_PER_ITEM; $j++) {
                                $subtitle = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . "contents{$i}_title{$j}");
                                $contents_text = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . "contents{$i}_text{$j}");
                                if ($subtitle) : ?>
                                    <li class="products_outline_item">
                                        <p class="products_outline_head"><?php echo $subtitle; ?></p>
                                        <p class="products_outline_text"><?php echo nl2br(auto_link_text(esc_html($contents_text))); ?></p>
                                    </li>
                            <?php
                                endif;
                            }
                            ?>
                        </ul>
                    <?php
                    }
                    ?>
                    <div class="bl_contactWrap">
                        <?php
                        $catalog_type = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'catalog_type');

                        if ($catalog_type === 'pdf') {
                            $file = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'pdf');
                            if ($file) : ?>
                                <a href="<?php echo esc_url($file['url']); ?>" download
                                    class="bl_contactWrap_download">製品カタログ＆リサイクル<br class="hp_nonePc">の取り組みを詳しく見る</a>
                            <?php endif;
                        } elseif ($catalog_type === 'external') {
                            $external_url = get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'external');
                            if ($external_url) : ?>
                                <a href="<?php echo esc_url($external_url); ?>" target="_blank" rel="noopener"
                                    class="bl_contactWrap_download">製品カタログ＆リサイクル<br class="hp_nonePc">の取り組みを詳しく見る</a>
                            <?php endif;
                        } elseif ($catalog_type === 'form') { ?>
                            <a href="<?php echo get_url(Page::CONTACT_DOWNLOAD, '', ['processed_production_name' => get_the_title()]) ?>"
                                class="bl_contactWrap_download">製品カタログ＆リサイクル<br class="hp_nonePc">の取り組みを詳しく見る</a>
                        <?php } ?>
                        <div class="bl_contactWrap_inner">
                            <p class="bl_contactWrap_text">
                                <?php the_title(); ?>への<br class="hp_nonePc">お問い合わせはこちら</p>
                            <p class="bl_contactWrap_explain"><?php echo nl2br(auto_link_text(esc_html(get_field(AcfField::PROCESSED_PRODUCTION_PREFIX . 'contact_text')))); ?></p>
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