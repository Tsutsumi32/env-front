<?php
if (!defined('ABSPATH')) exit;
get_header();
?>

<div class="bl_err">
    <p class="bl_err_num">404</p>
    <p class="bl_err_text">Page Not Found</p>
    <p class="bl_err_ex">
        ページが見つかりませんでした。<br>URLが変更・削除されたか、<br class="hp_nonePc">現在ご利用できない可能性がございます。
    </p>
    <div class="bl_err_buttonWrap">
        <a class="el_btn __type2" href="<?php echo get_url('') ?>">トップへ戻る</a>
    </div>
</div>
<!-- /.ly_section ly_section__top ly_section__radiusBt -->

<?php get_footer(); ?>