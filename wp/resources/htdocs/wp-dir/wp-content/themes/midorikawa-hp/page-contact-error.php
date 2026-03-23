<?php
if (!defined('ABSPATH')) exit;
get_header();
?>

<div class="bl_err">
    <p class="bl_err_head">お問合せエラー</p>
    <div class="ly_container">
        <p class="bl_err_ex">
            お問合せの送信に失敗しました。<br>大変お手数をおかけいたしますが、<br class="hp_nonePc">しばらくたってから再度送信をお願いいたします。
        </p>
    </div>
    <div class="bl_err_buttonWrap">
        <a class="el_btn __type2" href="<?php echo get_url('') ?>">トップへ戻る</a>
    </div>
</div>
<!-- /.ly_section ly_section__top ly_section__radiusBt -->

<?php get_footer(); ?>