<?php if (!defined('ABSPATH')) exit; ?>

<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>

<head prefix="og:http://ogp.me/ns#">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php // 番号・アドレス検知防止
    ?>
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <?php // リファラ情報の送信制御
    ?>
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <?php
    // タイトル
    require_once __DIR__ . '/inc/head/title.php';

    // ディスクリプション
    require_once __DIR__ . '/inc/head/description.php';

    // OGP
    require_once __DIR__ . '/inc/head/ogp.php';

    // ファビコン
    require_once __DIR__ . '/inc/head/favicon.php';

    // index
    require_once __DIR__ . '/inc/head/noindex.php';

    // カラー
    require_once __DIR__ . '/inc/head/theme-color.php';

    ?>

    <?php wp_head(); ?>
</head>

<body>

    <header class="header_area js_firstContents js_header<?php echo is_front_page() ? ' is_top' : null; ?>">
        <div class="header_inner">
            <div class="header_logoWrap">
                <a href="<?php echo get_url(''); ?>">
                    <img src="<?php echo_img('logo.png') ?>" alt="緑川化成工業株式会社" class="header_logoWrap_logo">
                    <img src="<?php echo_img('logo_white.png') ?>" alt="緑川化成工業株式会社" class="header_logoWrap_logo __white">
                </a>
                <p class="header_logoWrap_text hp_noneSp">アクリル製品開発、製造・加工、アクリル板材・資材、再生アクリル原料の販売</p>
            </div>
            <div class="header_nav hp_noneSp">
                <div class="header_nav_top">
                    <a href="<?php echo get_url(Page::PRODUCTS); ?>" class="el_btn">製品一覧・検索</a>
                    <a href="<?php echo get_url(Post::NEWS); ?>" class="el_btn">お知らせ</a>
                    <div class="header_nav_topInner">
                        <a href="<?php echo get_url(Page::CONTACT, 'contact-form'); ?>" class="el_btn __color">お問い合わせ</a>
                    </div>
                </div>
                <nav class="header_nav_bottom">
                    <ul class="header_nav_list">
                        <li class="header_nav_item js_headerSubMenuParent">
                            <span class="header_nav_link __nolink">事業一覧</span>
                            <ul class="header_nav_anchorList js_headerSubMenu">
                                <li class="header_nav_anchorList_item">
                                    <a href="<?php echo get_url(Page::DEVELOPMENT) ?>" class="header_nav_anchorList_link">アクリル製品の企画・開発</a>
                                </li>
                                <li class="header_nav_anchorList_item">
                                    <a href="<?php echo get_url(Page::TRAIDING) ?>" class="header_nav_anchorList_link">アクリルの総合商社</a>
                                </li>
                                <li class="header_nav_anchorList_item">
                                    <a href="<?php echo get_url(Page::PRODUCTION) ?>" class="header_nav_anchorList_link">アクリル製品の製造・加工</a>
                                </li>
                                <li class="header_nav_anchorList_item">
                                    <a href="<?php echo get_url(Page::RECYCLE) ?>" class="header_nav_anchorList_link">アクリル製品のリサイクル</a>
                                </li>
                            </ul>
                        </li>
                        <li class="header_nav_item">
                            <a href="<?php echo get_url(Page::COMPANY); ?>" class="header_nav_link">会社概要</a>
                        </li>
                        <li class="header_nav_item">
                            <a href="<?php echo get_url(Page::COMPANY, 'company-group'); ?>" class="header_nav_link">グループ会社</a>
                        </li>
                        <li class="header_nav_item">
                            <a href="<?php echo get_url(Page::SDGS); ?>" class="header_nav_link">サステナビリティ</a>
                        </li>
                        <li class="header_nav_item">
                            <a href="<?php echo get_url(Page::RECRUIT); ?>" class="header_nav_link">採用情報</a>
                        </li>
                    </ul>
                    <button type="button" class="header_language js_headerSubMenuParent">
                        <img src="<?php echo_img('icon_language.png') ?>" alt="言語を切り替える" class="header_language_icon">
                        <ul class="header_nav_anchorList __language js_headerSubMenu">
                            <li class="header_nav_anchorList_item">
                                <a href="<?php echo get_url(Page::TOP) ?>" class="header_nav_anchorList_link">日本語</a>
                            </li>
                            <li class="header_nav_anchorList_item">
                                <a href="#" class="header_nav_anchorList_link __disabled">English</a>
                            </li>
                            <li class="header_nav_anchorList_item">
                                <a href="#" class="header_nav_anchorList_link __disabled">中文</a>
                            </li>
                        </ul>
                    </button>
                </nav>
            </div>
            <button type="button" class="header_menuBtn hp_nonePc js_headerMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        <!-- /.header_inner -->
        <div class="header_menu js_headerMenu">
            <div class="header_menu_inner">
                <div class="ly_container">
                    <ul class="header_menu_list">
                        <li class="header_menu_item">
                            <span class="header_menu_label">( Company )</span>
                            <div class="header_menu_accordionWrap js_accordionParent">
                                <div class="header_menu_accordionBtn js_accordionBtn">
                                    <a href="<?php echo get_url(Page::COMPANY); ?>" class="header_menu_subject">緑川化成について</a>
                                </div>
                                <div class="header_menu_navWrap js_accordionContents">
                                    <ul class="header_menu_nav">
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::COMPANY, 'company-message'); ?>">代表挨拶</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::COMPANY, 'company-guide'); ?>">行動指針</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::COMPANY, 'company-history'); ?>">沿革</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::COMPANY, 'company-philosophy'); ?>">企業理念</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::COMPANY, 'company-outline'); ?>">会社概要</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::COMPANY, 'company-group'); ?>">グループ会社紹介</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- /.header_menu_item -->
                        <li class="header_menu_item">
                            <span class="header_menu_label">( Business )</span>
                            <div class="header_menu_accordionWrap js_accordionParent">
                                <div class="header_menu_accordionBtn js_accordionBtn">
                                    <span class="header_menu_subject">事業紹介</span>
                                </div>
                                <div class="header_menu_navWrap js_accordionContents">
                                    <ul class="header_menu_nav">
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::DEVELOPMENT) ?>">アクリル製品の企画・開発</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::PRODUCTION) ?>">アクリル製品の製造・加工</a>
                                        </li>
                                        <li class="header_menu_link __min144">
                                            <a href="<?php echo get_url(Page::TRAIDING) ?>">アクリルの総合商社</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::RECYCLE) ?>">アクリル製品のリサイクル</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- /.header_menu_item -->
                        <li class="header_menu_item">
                            <span class="header_menu_label">( Product )</span>
                            <div class="header_menu_accordionWrap">
                                <div class="header_menu_accordionBtn __noIcon">
                                    <a href="<?php echo get_url(Page::PRODUCTS); ?>" class="header_menu_subject">製品一覧・検索</a>
                                </div>
                            </div>
                        </li>
                        <!-- /.header_menu_item -->
                        <li class="header_menu_item">
                            <span class="header_menu_label">( Recruit )</span>
                            <div class="header_menu_accordionWrap js_accordionParent">
                                <div class="header_menu_accordionBtn js_accordionBtn">
                                    <a href="<?php echo get_url(Page::RECRUIT); ?>" class="header_menu_subject">採用情報</a>
                                </div>
                                <div class="header_menu_navWrap js_accordionContents">
                                    <ul class="header_menu_nav __space">
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::RECRUIT, 'recruit-message'); ?>">メッセージ</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::RECRUIT, 'recruit-request'); ?>">求める人物像</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::RECRUIT, 'recruit-training'); ?>">緑川化成工業の研修制度</a>
                                        </li>
                                        <li class="header_menu_link __min60">
                                            <a href="<?php echo get_url(Page::RECRUIT, 'recruit-interview'); ?>">先輩の声</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::RECRUIT, 'recruit-benefit'); ?>">福利厚生について</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- /.header_menu_item -->
                        <li class="header_menu_item">
                            <span class="header_menu_label">( News )</span>
                            <div class="header_menu_accordionWrap js_accordionParent">
                                <div class="header_menu_accordionBtn js_accordionBtn">
                                    <a href="<?php echo get_url(Post::NEWS); ?>" class="header_menu_subject">お知らせ</a>
                                </div>
                                <div class="header_menu_navWrap js_accordionContents">
                                    <ul class="header_menu_nav">
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Post::NEWS); ?>">全て</a>
                                        </li>
                                        <?php // カテゴリのリストを取得
                                        $categories = get_terms('news-category');
                                        usort($categories, function ($a, $b) {
                                            $order_a = get_term_meta($a->term_id, 'order', true);
                                            $order_b = get_term_meta($b->term_id, 'order', true);
                                            return intval($order_a) - intval($order_b);
                                        });
                                        foreach ($categories as $category) :
                                        ?>
                                            <li class="header_menu_link">
                                                <a href="<?php echo get_url(Post::NEWS) . '?category=' . $category->term_id . "&paged=1"; ?>">
                                                    <?php echo esc_html($category->name) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- /.header_menu_item -->
                        <li class="header_menu_item">
                            <span class="header_menu_label">( Sdgs )</span>
                            <div class="header_menu_accordionWrap">
                                <div class="header_menu_accordionBtn __noIcon">
                                    <a href="<?php echo get_url(Page::SDGS); ?>" class="header_menu_subject">サステナビリティ</a>
                                </div>
                            </div>
                        </li>
                        <!-- /.header_menu_item -->
                        <li class="header_menu_item">
                            <span class="header_menu_label">( Contact )</span>
                            <div class="header_menu_accordionWrap js_accordionParent">
                                <div class="header_menu_accordionBtn js_accordionBtn">
                                    <a href="<?php echo get_url(Page::CONTACT, 'contact-form'); ?>" class="header_menu_subject">お問い合わせ</a>
                                </div>
                                <div class="header_menu_navWrap js_accordionContents">
                                    <ul class="header_menu_nav">
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::CONTACT, 'contact-faq'); ?>">よくあるご質問</a>
                                        </li>
                                        <li class="header_menu_link">
                                            <a href="<?php echo get_url(Page::CONTACT, 'contact-form'); ?>">お問い合わせ</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- /.header_menu_item -->
                    </ul>
                    <!-- /.header_menu_list -->
                    <div class="header_menu_bottom">
                        <button type="button" class="header_language js_headerSubMenuParent">
                            <img src="<?php echo_img('icon_language.png') ?>" alt="言語を切り替える" class="header_language_icon">
                            <ul class="header_nav_anchorList __language js_headerSubMenu">
                                <li class="header_nav_anchorList_item">
                                    <a href="<?php echo get_url(Page::TOP) ?>" class="header_nav_anchorList_link">日本語</a>
                                </li>
                                <li class="header_nav_anchorList_item">
                                    <a href="#" class="header_nav_anchorList_link __disabled">English</a>
                                </li>
                                <li class="header_nav_anchorList_item">
                                    <a href="#" class="header_nav_anchorList_link __disabled">中文</a>
                                </li>
                            </ul>
                        </button>
                        <a href="<?php echo get_url(Page::PRIVACY_POLICY); ?>" class="header_menu_policy">プライバシーポリシー</a>
                    </div>
                    <p class="header_menu_copy">©︎Midorikawa Kasei Kogyo Co.</p>
                </div>
                <!-- /.ly_container -->
            </div>
            <!-- /.header_menu_inner -->
        </div>
        <!-- /.header_menu -->
    </header>
    <!-- /.header -->