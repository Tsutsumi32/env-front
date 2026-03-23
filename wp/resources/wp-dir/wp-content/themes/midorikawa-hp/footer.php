<?php if (!defined('ABSPATH')) exit; ?>

<?php
// 上部の余白が不要なページ
$noMargin = false;
if (
    is_page(Page::DEVELOPMENT)
    || is_page(Page::RECYCLE)
    || is_page(Page::RECRUIT)
    || is_page(Page::CONTACT)
    || is_page(Page::SDGS)
    || is_page(Page::PRODUCTION)
) {
    $noMargin = true;
}

// バナー上部に背景を入れるページ
$onBg = false;
if(
    is_front_page()
) {
    $onBg = true;
}
?>

<div class="footer_bnr<?php echo $noMargin ? ' __noPt' : null; ?><?php echo $onBg ? ' __onBg' : null; ?>">
    <a href="<?php echo get_url(Page::RECRUIT) ?>" class="footer_bnr_inner __recruit">
        <div class="footer_bnr_textWrap">
            <p class="footer_bnr_sub">( Recruit )</p>
            <p class="footer_bnr_head">採用情報</p>
        </div>
        <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="" class="footer_bnr_icon">
    </a>
    <a href="<?php echo get_url(Page::CONTACT, 'contact-form') ?>" class="footer_bnr_inner __contact">
        <div class="footer_bnr_textWrap">
            <p class="footer_bnr_sub">( Contact )</p>
            <p class="footer_bnr_head">各種お問い合せ</p>
        </div>
        <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="" class="footer_bnr_icon">
    </a>
</div>

<footer class=" footer_area">
    <div class="footer_inner">
        <div class="footer_top">
            <div class="footer_logoWrap">
                <a href="<?php echo get_url(''); ?>">
                    <img src="<?php echo_img('logo.png') ?>" alt="緑川化成工業株式会社" class="footer_logo">
                </a>
            </div>
            <div>
            <div class="footer_navParent">
                <div class="footer_nav_item">
                    <span class="footer_nav_link __nolink">事業紹介</span>
                    <ul class="footer_nav_subList">
                        <li class="footer_nav_subList_item">
                            <a href="<?php echo get_url(Page::DEVELOPMENT) ?>" class="footer_nav_subList_link">アクリル製品の企画・開発</a>
                        </li>
                        <li class="footer_nav_subList_item">
                            <a href="<?php echo get_url(Page::TRAIDING) ?>" class="footer_nav_subList_link">アクリルの総合商社</a>
                        </li>
                        <li class="footer_nav_subList_item">
                            <a href="<?php echo get_url(Page::PRODUCTION) ?>" class="footer_nav_subList_link">アクリル製品の製造・加工</a>
                        </li>
                        <li class="footer_nav_subList_item">
                            <a href="<?php echo get_url(Page::RECYCLE) ?>" class="footer_nav_subList_link">アクリル製品のリサイクル</a>
                        </li>
                    </ul>
                </div>
                <ul class="footer_nav">
                    <li class="footer_nav_item">
                        <a href="<?php echo get_url(Page::COMPANY); ?>" class="footer_nav_link">会社概要</a>
                    </li>
                    <li class="footer_nav_item">
                        <a href="<?php echo get_url(Post::NEWS); ?>" class="footer_nav_link">お知らせ</a>
                    </li>
                    <li class="footer_nav_item">
                        <a href="<?php echo get_url(Page::SDGS); ?>" class="footer_nav_link">サステナビリティ</a>
                    </li>
                    <li class="footer_nav_item">
                        <a href="<?php echo get_url(Page::PRODUCTS); ?>" class="footer_nav_link">製品一覧・検索</a>
                    </li>
                    <li class="footer_nav_item">
                        <a href="<?php echo get_url(Page::RECRUIT); ?>" class="footer_nav_link">採用情報</a>
                    </li>
                    <li class="footer_nav_item">
                        <a href="<?php echo get_url(Page::CONTACT, 'contact-form'); ?>" class="footer_nav_link">お問い合わせ</a>
                    </li>
                </ul>
            </div>
            <a href="<?php echo get_url(Page::PRIVACY_POLICY); ?>" class="footer_privacy">プライバシーポリシー</a>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <p class="footer_bottom_address">
            緑川化成工業株式会社<br>〒111-0043 東京都台東区駒形1-4-18
        </p>
        <div class="footer_bottom_imgWrap">
            <img src="<?php echo_img('img_policy.png') ?>" alt="ISO1 4001 ENVIRONMENTAL SYSTEM JQA-EM3386">
            <img src="<?php echo_img('icon_certificate.png') ?>" alt="第一号認定 経済産業省及び環境省 プラスチックに係る資源循環の促進等に関する法律に基づく自主回収・再資源化事業計画">
            <img src="<?php echo_img('icon_sdgs.png') ?>" alt="SDGs">
        </div>
    </div>
    <p class="footer_copy">©︎Midorikawa Kasei Kogyo Co.</p>
</footer>
<?php wp_footer(); ?>
</body>

</html>