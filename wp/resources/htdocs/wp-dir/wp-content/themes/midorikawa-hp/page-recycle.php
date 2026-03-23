<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path( '/inc/components/breadcrumbs.php' )); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Business )</span>
            <h1 class="bl_secondPageHead_head __nowrap">アクリル製品のリサイクル</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <section class="ly_section __pB __ptSmaller">
        <div class="ly_container">
            <img src="<?php echo_img('icon_sdgs.png') ?>" alt="" class="recycle_sdgsImg">
            <h2 class="recycle_sdgsHead">未来を守る、緑川グループSDGsへの挑戦。</h2>
            <p class="recycle_sdgsText">
                緑川グループは、「限りある資源を守り、未来を創る」という理念のもと、SDGs（持続可能な開発目標）の達成に向けた取り組みを推進しています。環境、社会、経済の調和を目指し、私たちはサステナビリティを実現するための具体的な行動を続けています。
            </p>
            <section class="recycle_works">
                <h3 class="recycle_works_head">
                    数字で見る緑川グループの<br class="hp_nonePc">リサイクル実績
                </h3>
                <ul class="recycle_works_list">
                    <li class="recycle_works_item">
                        <p class="recycle_works_subject">廃材の回収量</p>
                        <p class="recycle_works_result">
                            年間<span class="recycle_works_number">00</span>トン
                        </p>
                        <p class="recycle_works_explain">
                            年間○○トンの廃材を回収・再生しています。
                        </p>
                    </li>
                    <li class="recycle_works_item">
                        <p class="recycle_works_subject">製品化率</p>
                        <p class="recycle_works_result">
                            <span class="recycle_works_number">00</span>%
                        </p>
                        <p class="recycle_works_explain">
                            廃材の○％を高品質素材として再生しています。
                        </p>
                    </li>
                    <li class="recycle_works_item">
                        <p class="recycle_works_subject">CO2削減効果</p>
                        <p class="recycle_works_result">
                            年間<span class="recycle_works_number">00</span>トン
                        </p>
                        <p class="recycle_works_explain">
                            リサイクル技術で年間○○トンの排出削減に成功。
                        </p>
                    </li>
                </ul>
            </section>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <section class="ly_section __color">
        <div class="ly_container __mx982">
            <div class="bl_head3">
                <span class="bl_head3_sub">リサイクル製品開発実績</span>
                <h2 class="bl_head3_text">再生アクリル板<br class="hp_nonePc">「リアライト®」</h2>
            </div>
            <div class="recycle_rearlightWrap">
                <div class="recycle_rearlightWrap_imgWrap">
                    <img src="<?php echo_img('recycle_img_rearlight.jpg') ?>" alt="">
                </div>
                <div class="recycle_rearlightWrap_textWrap">
                    <p class="recycle_rearlightWrap_text">
                        リアライト®は、使用済みアクリルを回収・再生し、新たなアクリル板として生まれ変わった環境配慮型製品です。<br><br>バージンアクリルと同等の透明度・強度・加工性 を持ちながら、CO₂排出量の削減や廃棄物の削減に貢献 します。商業施設のディスプレイや建築資材、車両部品など、さまざまな用途で活用されており、持続可能なものづくりを支える次世代アクリル素材 です。
                    </p>
                    <a href="<?php echo get_url(Page::REARLIGHT) ?>" class="el_btn __type2 __wide">「リアライト®]詳細を見る</a>
                </div>
            </div>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <section class="ly_section __pB">
        <h2 class="recycle_featureHead">循環型ものづくりで未来を支える</h2>
        <div class="ly_container">
            <p class="recycle_featurePoint">緑川グループの総合力<br class="hp_nonePc"> × <br class="hp_nonePc">循環型ソリューション</p>
            <p class="recycle_featureText hp_noneSp">
                緑川グループは、11のグループ企業と約3,000社の協力会社と共に、多様な業界の課題解決に取り組んでいます。<br>私たちの提供する製品は、単なる「ものづくり」ではなく、使用後も回収・再生し、新たな価値へと生まれ変わる<span>「循環型ものづくり」</span>です。<br>これからも、時代の変化に応じた製品ラインナップを展開し、暮らしと産業に役立つ多彩な製品をお届けしてまいります。
            </p>
            <picture>
                <source media="(max-width: <?php echo BREAK_PC ?>)" srcset="<?php echo_img('recycle_img_feature_sp.svg') ?>">
                <img src="<?php echo_img('recycle_img_feature.svg') ?>" alt="循環型ものづくりのプロセス 01製品提供 高品質な樹脂製品を各業界へ供給 耐久性・機能性に優れた製品を、自動車・鉄道・航空・建機など幅広い業界へ提供。用途に応じた素材選定と加工技術で、最適なソリューションを実現。02 使用・消耗 高性能な製品として活躍 軽量・高耐候・高耐衝撃の製品が、車両内装や駅案内板など多様なシーンで活躍。長寿命設計で環境負荷の低減にも貢献。 03 廃材回収 使用後の製品を回収・分別 役目を終えた製品を回収し、素材ごとに適切に分別。廃棄物削減とリサイクルの効率化を推進。 04 再資源化再製品化 廃材を新たな製品へ 回収素材をリサイクルし、新たな樹脂原料や再生アクリル板へ。CO2排出削減と資源の有効活用を実現。" class="recycle_featureImg">
            </picture>
            <p class="recycle_featureText hp_nonePc">
                緑川グループは、11のグループ企業と約3,000社の協力会社と共に、多様な業界の課題解決に取り組んでいます。<br>私たちの提供する製品は、単なる「ものづくり」ではなく、使用後も回収・再生し、新たな価値へと生まれ変わる<span>「循環型ものづくり」</span>です。<br>これからも、時代の変化に応じた製品ラインナップを展開し、暮らしと産業に役立つ多彩な製品をお届けしてまいります。
            </p>
            <ul class="recycle_featureList hp_nonePc">
                <li class="recycle_featureList_item">
                    <div class="recycle_featureList_headWrap">
                        <span class="recycle_featureList_number">01</span>
                        <p class="recycle_featureList_head">製品提供</p>
                    </div>
                    <p class="recycle_featureList_sub">高品質な樹脂製品を各業界へ供給</p>
                    <p class="recycle_featureList_text">耐久性・機能性に優れた製品を、自動車・鉄道・航空・建機など幅広い業界へ提供。用途に応じた素材選定と加工技術で、最適なソリューションを実現。</p>
                </li>
                <li class="recycle_featureList_item">
                    <div class="recycle_featureList_headWrap">
                        <span class="recycle_featureList_number">02</span>
                        <p class="recycle_featureList_head">使用・消耗</p>
                    </div>
                    <p class="recycle_featureList_sub">高性能な製品として活躍</p>
                    <p class="recycle_featureList_text">軽量・高耐候・高耐衝撃の製品が、車両内装や駅案内板など多様なシーンで活躍。長寿命設計で環境負荷の低減にも貢献。</p>
                </li>
                <li class="recycle_featureList_item">
                    <div class="recycle_featureList_headWrap">
                        <span class="recycle_featureList_number">03</span>
                        <p class="recycle_featureList_head">廃材回収</p>
                    </div>
                    <p class="recycle_featureList_sub">使用後の製品を回収・分別</p>
                    <p class="recycle_featureList_text">役目を終えた製品を回収し、素材ごとに適切に分別。廃棄物削減とリサイクルの効率化を推進。</p>
                </li>
                <li class="recycle_featureList_item">
                    <div class="recycle_featureList_headWrap">
                        <span class="recycle_featureList_number">04</span>
                        <p class="recycle_featureList_head">再資源化再製品化</p>
                    </div>
                    <p class="recycle_featureList_sub">廃材を新たな製品へ</p>
                    <p class="recycle_featureList_text">回収素材をリサイクルし、新たな樹脂原料や再生アクリル板へ。CO2排出削減と資源の有効活用を実現。</p>
                </li>
            </ul>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <section class="ly_section __gray">
        <div class="ly_container __mx962">
            <div class="bl_head3">
                <span class="bl_head3_sub">緑川化成の技術力</span>
                <h2 class="bl_head3_text">資源を未来へ。<br>緑川グループの<br class="hp_nonePc">リサイクル技術力。</h2>
            </div>
            <div class="recycle_skillWrap">
                <p class="recycle_skillWrap_text">
                    緑川グループは、限りある資源を守り、循環型社会を実現するために最先端のリサイクル技術を活用し、業界をリードしています。廃材を選別・再原料化し、新たな製品へと生まれ変わらせる独自の技術で、資源の無駄を最小限に抑えつつ、高品質なリサイクル素材を提供しています。また、再生プロセスによる環境負荷の低減やCO2排出量の削減にも取り組み、持続可能な未来を形にしています。
                </p>
                <div class="recycle_skillWrap_imgWrap">
                    <img src="<?php echo_img('recycle_img_skill.jpg') ?>" alt="">
                </div>
            </div>
            <ul class="recycle_skillList">
                <li class="recycle_skillList_item">
                    <span class="recycle_skillList_number">( 01 )</span>
                    <div class="recycle_skillList_textWrap">
                        <p class="recycle_skillList_head">
                            クローズド・リサイクルの実現
                        </p>
                        <div class="recycle_skillList_imgWrap hp_nonePc">
                            <img src="<?php echo_img('recycle_img_skill_list1.jpg') ?>" alt="">
                        </div>
                        <p class="recycle_skillList_intro">
                            「リアライト®」を使用した製品を回収し、<br>新たなアクリル板へ再生。
                        </p>
                        <p class="recycle_skillList_text">
                            緑川グループのリサイクル技術は、資源の循環利用を可能にする独自の仕組みを構築しています。たとえば、自社ブランドのリサイクルアクリル板「リアライト®」を使用した製品を回収し、新たなアクリル板へと再生。廃材を無駄にすることなく、資源として再び生まれ変わらせることで、持続可能な社会の実現に貢献しています。
                        </p>
                    </div>
                    <div class="recycle_skillList_imgWrap hp_noneSp">
                        <img src="<?php echo_img('recycle_img_skill_list1.jpg') ?>" alt="">
                    </div>
                </li>
                <li class="recycle_skillList_item">
                    <span class="recycle_skillList_number">( 02 )</span>
                    <div class="recycle_skillList_textWrap">
                        <p class="recycle_skillList_head">
                            高度な再生プロセス
                        </p>
                        <div class="recycle_skillList_imgWrap hp_nonePc">
                            <img src="<?php echo_img('recycle_img_skill_list2.jpg') ?>" alt="">
                        </div>
                        <p class="recycle_skillList_intro">
                            廃材の選別から再原料化まで一貫対応。<br>最新設備とノウハウで高品質なリサイクル素材を提供。
                        </p>
                        <p class="recycle_skillList_text">
                            廃材の選別から再原料化、さらに新製品としての加工に至るまで、全てのプロセスを一貫して対応できる体制を整えています。最新の設備と長年培ったノウハウを活かし、高品質なリサイクル素材を安定的に供給。これにより、顧客のニーズに応じた最適なソリューションを提供することが可能です。
                        </p>
                    </div>
                    <div class="recycle_skillList_imgWrap hp_noneSp">
                        <img src="<?php echo_img('recycle_img_skill_list2.jpg') ?>" alt="">
                    </div>
                </li>
                <li class="recycle_skillList_item">
                    <span class="recycle_skillList_number">( 03 )</span>
                    <div class="recycle_skillList_textWrap">
                        <p class="recycle_skillList_head">
                            多分野への応用力
                        </p>
                        <div class="recycle_skillList_imgWrap hp_nonePc">
                            <img src="<?php echo_img('recycle_img_skill_list3.jpg') ?>" alt="">
                        </div>
                        <p class="recycle_skillList_intro">
                            再生アクリル板をはじめ、<br>自動車部品や建築材料など多岐にわたる製品展開。
                        </p>
                        <p class="recycle_skillList_text">
                            緑川グループのリサイクル素材は、単なるアクリル製品に留まらず、自動車部品、建築用資材、環境関連製品など、多岐にわたる分野で採用されています。これらの応用力の高さは、グループ全体の技術力と柔軟性を象徴しており、多様な市場ニーズに応える製品展開を実現しています。
                        </p>
                    </div>
                    <div class="recycle_skillList_imgWrap hp_noneSp">
                        <img src="<?php echo_img('recycle_img_skill_list3.jpg') ?>" alt="">
                    </div>
                </li>
                <li class="recycle_skillList_item">
                    <span class="recycle_skillList_number">( 04 )</span>
                    <div class="recycle_skillList_textWrap">
                        <p class="recycle_skillList_head">
                            環境負荷の低減
                        </p>
                        <div class="recycle_skillList_imgWrap hp_nonePc">
                            <img src="<?php echo_img('recycle_img_skill_list4.jpg') ?>" alt="">
                        </div>
                        <p class="recycle_skillList_intro">
                            リサイクルによる資源循環で、<br>CO2削減と海洋汚染防止に貢献。
                        </p>
                        <p class="recycle_skillList_text">
                            リサイクルプロセス全体を通じてCO2排出量の削減に取り組むとともに、使用済み製品の回収・再生を徹底することで、廃棄物が海洋に流出するのを防ぎ、マイクロプラスチックによる環境汚染を抑制しています。単なる廃棄物削減にとどまらず、資源の循環利用を推進することで、海洋環境への負荷を軽減し、持続可能な未来を支えます。
                        </p>
                    </div>
                    <div class="recycle_skillList_imgWrap hp_noneSp">
                        <img src="<?php echo_img('recycle_img_skill_list4.jpg') ?>" alt="">
                    </div>
                </li>
            </ul>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>