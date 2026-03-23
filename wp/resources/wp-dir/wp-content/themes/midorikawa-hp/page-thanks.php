<?php
if (!defined('ABSPATH')) exit;

// お問合せ画面からでない場合リダイレクト
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if (
    empty($referer) ||
    (
        strpos($referer, home_url('/contact/')) === false &&
        strpos($referer, home_url('/contact-download/')) === false
    )
) {
    // リダイレクト
    wp_redirect(get_url(Page::TOP));
    exit;
}

get_header();
?>
<main class="ly_main">
    <div class="ly_container">
        <div class="thanks_wrap">
            <p class="thanks_text">
                お問い合わせを受け付けました。<br>
                内容を確認の上、<br class="hp_nonePc">担当者よりご連絡いたしますので、<br>
                今しばらくお待ちください。
            </p>
            <a class="el_btn __type2" href="<?php echo get_url(''); ?>">TOPへ</a>
        </div>
    </div>
    <!-- /.ly_container -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>