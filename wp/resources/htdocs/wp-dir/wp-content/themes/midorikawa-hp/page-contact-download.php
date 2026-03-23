<?php
if (!defined('ABSPATH')) exit;

if (
    !(isset($_GET['product_name']) && $_GET['product_name'] !== '')
    && !(isset($_GET['processed_production_name']) && $_GET['processed_production_name'] !== '')
) {
    // リダイレクト
    wp_redirect(get_url(Page::TOP));
    exit;
}

get_header();
?>



<?php
// 一般お問い合わせフォームを表示
$forms = get_posts([
    'post_type' => 'wpcf7_contact_form',
    'title' => 'ダウンロードフォーム',
    'posts_per_page' => 1
]);
?>

<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc//components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Download Form )</span>
            <h1 class="bl_secondPageHead_head">ダウンロードフォーム</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="js_loading"></div>
    <section class="ly_section __gray js_contactSection js_anchorLinkTarget" id="contact-form">
        <div class="ly_container js_formInputPage">
            <p class="contact_intro __center">各種カタログ・SDSなどのダウンロードは下記フォームにて承ります。<br>必要事項をご記入の上、一番下の「内容を確認する」ボタンを押してください。</p>
            <p class="contact_annotation __center">
                <span class="contact_annotation__point">*</span> は入力必須項目です。
            </p>
            <?php
            if ($forms) {
                echo do_shortcode('[contact-form-7 id="' . $forms[0]->ID . '" title="ダウンロードフォーム"]');
            }
            ?>
        </div>
        <!-- /.ly_container -->
        <?php // 確認UI読み込み
        ?>
        <div id="formConfirmPage" class="bl_formConfirm">
            <?php require(get_theme_file_path('/inc/components/contact-download-confirm.php')); ?>
        </div>
    </section>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>