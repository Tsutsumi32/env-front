<?php
if (!defined('ABSPATH')) exit;
get_header();
?>

<?php
// 一般お問い合わせフォームを表示
$forms = get_posts([
    'post_type' => 'wpcf7_contact_form',
    'title' => 'お問い合わせ',
    'posts_per_page' => 1
]);
?>

<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Contact )</span>
            <h1 class="bl_secondPageHead_head">お問い合わせ</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="ly_flexContainer">
        <div class="ly_flexSide js_formInputPage">
            <ul class="bl_anchorLink __mtSmall hp_noneSp">
                <li class="bl_anchorLink_item js_anchorLink is_active">
                    <a href="#contact-faq" class="bl_anchorLink_link">よくあるご質問</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#contact-form" class="bl_anchorLink_link">お問い合わせ</a>
                </li>
                </li>
            </ul>
            <!-- /.bl_anchorLink -->
        </div>
        <!-- /.ly_flexSide -->
        <div class="ly_flexInner">
            <section class="ly_section __pB js_formInputPage">
                <div class="ly_container">
                    <div class="bl_selectWrap hp_nonePc js_accordionParent">
                        <p class="bl_selectWrap_head">Category</p>
                        <button type="button" class="bl_selectWrap_btn js_selectText js_accordionBtn">
                            よくあるご質問
                        </button>
                        <ul class="bl_select js_accordionContents">
                            <li class="bl_select_item">
                                <a href="#contact-faq" class="bl_select_link js_accordionItem js_selectTextItem">よくあるご質問</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#contact-form" class="bl_select_link js_accordionItem js_selectTextItem">お問い合わせ</a>
                            </li>
                        </ul>
                    </div>
                    <div class="bl_head3 js_anchorLinkTarget" id="contact-faq">
                        <span class="bl_head3_sub">よくあるご質問</span>
                        <h2 class="bl_head3_text">FAQ</h2>
                    </div>
                    <section class="contact_qaSection">
                        <h3 class="el_labelHead">はじめてのお取引</h3>
                        <ul class="bl_qa">
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        今まで取引が無いのですが、新規の見積は可能でしょうか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer">
                                            可能です。お問い合わせフォームから、ご希望の商品と数量、また現行の購入価格等ご予算があれば併せてご依頼ください。担当の営業部署よりご連絡いたします。<br>または、事業所一覧ページの最寄り営業所まで直接お問い合わせください。
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        個人で購入することは可能でしょうか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        支払い条件について教えてください
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        クレジットカードでの決済は可能でしょうか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <!-- /.contact_qaSection -->
                    <section class="contact_qaSection">
                        <h3 class="el_labelHead">商品について</h3>
                        <ul class="bl_qa">
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        サンプルの依頼は可能でしょうか
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer">
                                            可能です。ご希望の商品名、サイズ・数量等をお問い合わせフォームよりご依頼ください。<br>ただし、一部メーカーの商品に関しては有償でのご用意となる場合もございます。予めご了承ください。
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        プラスチック板を希望のサイズにカット加工してもらうことは可能でしょうか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        金属や木材など、プラスチック以外の材料の取り扱いは可能でしょうか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        現場の施工をお願いすることは可能でしょうか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        製品のSDS（安全データシート）や出荷証明・材料証明などの証明書は入手できますか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        リサイクル材について興味があるので教えてください。
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        海外に納入してもらうことは可能でしょうか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <!-- /.contact_qaSection -->
                    <section class="contact_qaSection">
                        <h3 class="el_labelHead">営業日・営業時間</h3>
                        <ul class="bl_qa">
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        土・日・祝日は営業していますか？
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer">
                                            申し訳ございませんが、カレンダー通りの営業日となっております。
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="bl_qa_item js_accordionParent">
                                <div class="bl_qa_qWrap js_accordionBtn">
                                    <span class="bl_qa_label">Q</span>
                                    <p class="bl_qa_question">
                                        営業時間を教えて下さい。
                                    </p>
                                </div>
                                <div class="bl_qa_aParent js_accordionContents">
                                    <div class="bl_qa_aWrap">
                                        <span class="bl_qa_label">A</span>
                                        <p class="bl_qa_answer"></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <!-- /.contact_qaSection -->
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <div class="js_loading"></div>
            <section class="ly_section __gray js_contactSection js_anchorLinkTarget" id="contact-form">
                <div class="ly_container js_formInputPage">
                    <div class="bl_head3 __noPcMb">
                        <span class="bl_head3_sub">お問い合わせ</span>
                        <h2 class="bl_head3_text">お問い合わせフォーム</h2>
                    </div>
                    <p class="contact_intro">お問い合わせ・エントリーは以下のフォームよりご連絡ください。<br class="hp_noneSp">2～3営業日以内に、担当よりメールにて返信させていただきます。</p>
                    <p class="contact_annotation">
                        <span class="contact_annotation__point">*</span> は入力必須項目です。
                    </p>
                    <?php
                    if ($forms) {
                        echo do_shortcode('[contact-form-7 id="' . $forms[0]->ID . '" title="お問い合わせ"]');
                    }
                    ?>
                </div>
                <!-- /.ly_container -->
                <?php // 確認UI読み込み
                ?>
                <div id="formConfirmPage" class="bl_formConfirm">
                    <?php require(get_theme_file_path('/inc/components/contact-confirm.php')); ?>
                </div>
            </section>
            <!-- /.ly_section -->
        </div>
        <!-- /.ly_flexInner -->
    </div>
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>