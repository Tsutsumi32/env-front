<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path( '/inc/components/breadcrumbs.php' )); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Business )</span>
            <h1 class="bl_secondPageHead_head __nowrap">アクリル製品の製造・加工</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="ly_section __ptSmall">
        <div class="ly_container">
            <p class="production_intro">
                各地に広がる最先端設備で、<br>幅広い製造・加工を実現します。
            </p>
        </div>
        <!-- /.ly_container -->
        <div class="production_map">
            <img src="<?php echo_img(('production_img_map.svg')) ?>" alt="" class="production_map_img">
            <div class="production_map_item js_modalOpen" data-modal="production1">
                <img src="<?php echo_img(('production_img_item1.jpg')) ?>" alt="">
            </div>
            <div class="production_map_item js_modalOpen" data-modal="production2">
                <img src="<?php echo_img(('production_img_item2.jpg')) ?>" alt="">
            </div>
            <div class="production_map_item js_modalOpen" data-modal="production3">
                <img src="<?php echo_img(('production_img_item3.jpg')) ?>" alt="">
            </div>
            <div class="production_map_item js_modalOpen" data-modal="production4">
                <img src="<?php echo_img(('production_img_item4.jpg')) ?>" alt="">
            </div>
            <div class="production_map_item js_modalOpen" data-modal="production5">
                <img src="<?php echo_img(('production_img_item5.jpg')) ?>" alt="">
            </div>
            <div class="production_map_item js_modalOpen" data-modal="production6">
                <img src="<?php echo_img(('production_img_item6.jpg')) ?>" alt="">
            </div>
        </div>
    </div>
    <!-- /.ly_section -->

    <section class="ly_section __grayPbLarge">
        <div class="ly_container">
            <div class="bl_head3 __pcCenter">
                <span class="bl_head3_sub">製品・ソリューションの紹介</span>
                <h2 class="bl_head3_text">加工・施工一覧</h2>
            </div>
            <ul class="production_list">
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list1.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_VEHICLE) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">乗り物</h3>
                            <p class="production_list_intro">
                                耐久性とリサイクル性を兼ね備えた部品を開発し、使用後も再生可能なシステムを構築。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎自動車、鉄道、航空機の内装・外装部品を、耐候性・耐衝撃性に優れた素材で提供。<br><br>
                                ▶︎回収システムを整備し、使用後の内装部品やパネルを再生アクリル板や新素材としてリサイクル。<br><br>
                                ▶︎高耐久でありながら、環境負荷を低減する持続可能なモビリティ部品を開発。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎自動車、鉄道、航空機の内装・外装部品を、耐候性・耐衝撃性に優れた素材で提供。<br><br>
                        ▶︎回収システムを整備し、使用後の内装部品やパネルを再生アクリル板や新素材としてリサイクル。<br><br>
                        ▶︎高耐久でありながら、環境負荷を低減する持続可能なモビリティ部品を開発。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_VEHICLE) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list2.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_FACTORY) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">工場</h3>
                            <p class="production_list_intro">
                                高機能な設備部品を提供し、使用後も回収・再資源化。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎製造現場で使用される保護カバー、導光板、機器パネルを高耐久・高機能素材で製造。<br><br>
                                ▶︎使用後の設備部品を回収し、新たな工場用部材へとリサイクルするサプライチェーンを構築。<br><br>
                                ▶︎工場のカーボンニュートラル推進のため、省エネ型部材やリサイクル材を活用。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎製造現場で使用される保護カバー、導光板、機器パネルを高耐久・高機能素材で製造。<br><br>
                        ▶︎使用後の設備部品を回収し、新たな工場用部材へとリサイクルするサプライチェーンを構築。<br><br>
                        ▶︎工場のカーボンニュートラル推進のため、省エネ型部材やリサイクル材を活用。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_FACTORY) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list3.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_MEDICAL) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">医療</h3>
                            <p class="production_list_intro">
                                再生可能な高機能アクリルを<br class="hp_noneSp">活用し、持続可能な医療環境を提供。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎抗菌・抗ウイルス加工を施したリサイクル可能な医療機器カバーを開発。<br><br>
                                ▶︎病院や診療所で使用されるクリアパネルや医療用機器ケースを高機能・再生素材で製造。<br><br>
                                ▶︎使用後は回収し、新たな医療機器部品や院内設備用パーツに再利用。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎抗菌・抗ウイルス加工を施したリサイクル可能な医療機器カバーを開発。<br><br>
                        ▶︎病院や診療所で使用されるクリアパネルや医療用機器ケースを高機能・再生素材で製造。<br><br>
                        ▶︎使用後は回収し、新たな医療機器部品や院内設備用パーツに再利用。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_MEDICAL) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list4.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_ENVIRONMENT) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">環境</h3>
                            <p class="production_list_intro">
                                「リアライト®」を活用し、持続可能な社会を支える。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎自社ブランドのリサイクルアクリル板「リアライト®」を提供し、廃材の削減と資源循環を促進。<br><br>
                                ▶︎店舗・工場・施設などで使用されたリアライト®製品を回収し、新たなアクリル板へと再生。<br><br>
                                ▶CO2排出量削減やマイクロプラスチック対策にも貢献。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎自社ブランドのリサイクルアクリル板「リアライト®」を提供し、廃材の削減と資源循環を促進。<br><br>
                        ▶︎店舗・工場・施設などで使用されたリアライト®製品を回収し、新たなアクリル板へと再生。<br><br>
                        ▶CO2排出量削減やマイクロプラスチック対策にも貢献。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_ENVIRONMENT) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list5.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_OFFICE) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">住宅・オフィス</h3>
                            <p class="production_list_intro">
                                デザイン性と環境配慮を両立した内装材を提供し、資源循環を推進。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎インテリア装飾やオフィス什器に適したデザイン性の高いリサイクル素材を提供。<br><br>
                                ▶︎廃棄時には回収し、内装パネルや家具パーツとして再生可能な仕組みを整備。<br><br>
                                ▶︎美しさと機能性を兼ね備え、長期使用を前提としたサステナブルな空間づくりを支援。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎インテリア装飾やオフィス什器に適したデザイン性の高いリサイクル素材を提供。<br><br>
                        ▶︎廃棄時には回収し、内装パネルや家具パーツとして再生可能な仕組みを整備。<br><br>
                        ▶︎美しさと機能性を兼ね備え、長期使用を前提としたサステナブルな空間づくりを支援。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_OFFICE) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list6.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_COMMERCIAL) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">商業施設</h3>
                            <p class="production_list_intro">
                                耐久性・意匠性の高い商業施設向け資材を提供し、リサイクル可能な設計を推進。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎看板・ディスプレイ・内装パネルなど、意匠性と耐久性を両立した素材を提供。<br><br>
                                ▶︎使用後のサインディスプレイを回収し、新たなディスプレイ素材へ再加工。<br><br>
                                ▶︎商業空間における廃棄物削減と資源活用を実現。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎看板・ディスプレイ・内装パネルなど、意匠性と耐久性を両立した素材を提供。<br><br>
                        ▶︎使用後のサインディスプレイを回収し、新たなディスプレイ素材へ再加工。<br><br>
                        ▶︎商業空間における廃棄物削減と資源活用を実現。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_COMMERCIAL) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list7.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_AMUSEMENT) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">アミューズメント</h3>
                            <p class="production_list_intro">
                                高耐久・環境配慮型の設備素材を提供し、施設全体のサステナビリティを向上。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎遊戯機器、施設設備、照明カバーなどに適した高機能素材を使用。<br><br>
                                ▶︎使用後の機器パーツや照明カバーを回収し、再利用可能な素材へリサイクル。<br><br>
                                ▶︎アミューズメント業界におけるサステナブルな施設運営をサポート。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎遊戯機器、施設設備、照明カバーなどに適した高機能素材を使用。<br><br>
                        ▶︎使用後の機器パーツや照明カバーを回収し、再利用可能な素材へリサイクル。<br><br>
                        ▶︎アミューズメント業界におけるサステナブルな施設運営をサポート。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_AMUSEMENT) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
                <li class="production_list_item">
                    <div class="production_list_inner">
                        <div class="production_list_imgWrap">
                            <img src="<?php echo_img(('production_img_list8.jpg')) ?>" alt="">
                            <a href="<?php echo get_url(Page::PRODUCTION_AGRICULTURE) ?>" class="el_btn __type2 hp_noneSpFlex __small">製品を見る</a>
                        </div>
                        <div class="production_list_textWrap">
                            <h3 class="production_list_head">農水産業</h3>
                            <p class="production_list_intro __spacing">
                                農水産業を支える資材を提供し、環境負荷の少ない製品を開発。
                            </p>
                            <p class="production_list_explain hp_noneSp">
                                ▶︎再生アクリルやリサイクル樹脂を活用し、ハウス用パネルや水産用設備資材を製造。<br><br>
                                ▶︎使用後の資材を回収し、農業・水産業向けの新たな製品へ再生。<br><br>
                                ▶︎持続可能な食糧生産を支える循環型ソリューションを提供。
                            </p>
                        </div>
                    </div>
                    <p class="production_list_explain hp_nonePc">
                        ▶︎再生アクリルやリサイクル樹脂を活用し、ハウス用パネルや水産用設備資材を製造。<br><br>
                        ▶︎使用後の資材を回収し、農業・水産業向けの新たな製品へ再生。<br><br>
                        ▶︎持続可能な食糧生産を支える循環型ソリューションを提供。
                    </p>
                    <a href="<?php echo get_url(Page::PRODUCTION_AGRICULTURE) ?>" class="el_btn __type2 hp_nonePc __small">製品を見る</a>
                </li>
                <!-- /.production_list_item -->
            </ul>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->

<div class="bl_modal js_modal" data-modal="production1">
    <div class="bl_modal_contents">
        <button type="button" class="bl_modal_close js_modalClose"></button>
        <div class="bl_modal_inner js_modalScroll">
            <img src="<?php echo_img(('production_img_item1.jpg')) ?>" alt="" class="bl_modal_img">
            <p class="bl_modal_head">テキストテキストテキスト</p>
            <p class="bl_modal_subject">テキストテキストテキスト</p>
            <p class="bl_modal_text">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        </div>
    </div>
</div>

<div class="bl_modal js_modal" data-modal="production2">
    <div class="bl_modal_contents">
        <button type="button" class="bl_modal_close js_modalClose"></button>
        <div class="bl_modal_inner js_modalScroll">
            <img src="<?php echo_img(('production_img_item2.jpg')) ?>" alt="" class="bl_modal_img">
            <p class="bl_modal_head">テキストテキストテキスト</p>
            <p class="bl_modal_subject">テキストテキストテキスト</p>
            <p class="bl_modal_text">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        </div>
    </div>
</div>

<div class="bl_modal js_modal" data-modal="production3">
    <div class="bl_modal_contents">
        <button type="button" class="bl_modal_close js_modalClose"></button>
        <div class="bl_modal_inner js_modalScroll">
            <img src="<?php echo_img(('production_img_item3.jpg')) ?>" alt="" class="bl_modal_img">
            <p class="bl_modal_head">テキストテキストテキスト</p>
            <p class="bl_modal_subject">テキストテキストテキスト</p>
            <p class="bl_modal_text">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        </div>
    </div>
</div>

<div class="bl_modal js_modal" data-modal="production4">
    <div class="bl_modal_contents">
        <button type="button" class="bl_modal_close js_modalClose"></button>
        <div class="bl_modal_inner js_modalScroll">
            <img src="<?php echo_img(('production_img_item4.jpg')) ?>" alt="" class="bl_modal_img">
            <p class="bl_modal_head">テキストテキストテキスト</p>
            <p class="bl_modal_subject">テキストテキストテキスト</p>
            <p class="bl_modal_text">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        </div>
    </div>
</div>

<div class="bl_modal js_modal" data-modal="production5">
    <div class="bl_modal_contents">
        <button type="button" class="bl_modal_close js_modalClose"></button>
        <div class="bl_modal_inner js_modalScroll">
            <img src="<?php echo_img(('production_img_item5.jpg')) ?>" alt="" class="bl_modal_img">
            <p class="bl_modal_head">テキストテキストテキスト</p>
            <p class="bl_modal_subject">テキストテキストテキスト</p>
            <p class="bl_modal_text">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        </div>
    </div>
</div>

<div class="bl_modal js_modal" data-modal="production6">
    <div class="bl_modal_contents">
        <button type="button" class="bl_modal_close js_modalClose"></button>
        <div class="bl_modal_inner js_modalScroll">
            <img src="<?php echo_img(('production_img_item6.jpg')) ?>" alt="" class="bl_modal_img">
            <p class="bl_modal_head">テキストテキストテキスト</p>
            <p class="bl_modal_subject">テキストテキストテキスト</p>
            <p class="bl_modal_text">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        </div>
    </div>
</div>
<?php get_footer(); ?>