<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Business )</span>
            <h1 class="bl_secondPageHead_head __nowrap">アクリル製品の企画・開発</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <section class="ly_section __pB __ptSmall">
        <div class="ly_container">
            <div class="bl_head3">
                <span class="bl_head3_sub">緑川グループの実績</span>
                <h2 class="bl_head3_text">主な開発実績</h2>
            </div>
            <ul class="development_works">
                <li class="development_works_item">
                    <img src="<?php echo_img(('development_img_works1.jpg')) ?>" alt="" class="development_works_img">
                    <p class="development_works_head">医療機器用抗菌プラスチック部品</p>
                    <p class="development_works_text">
                        医療現場では、感染予防が最重要課題のひとつです。特に、機器の部品に求められる抗菌性や安全性は厳しい基準が設定されています。緑川化成工業は、このようなニーズに応えるべく、抗菌性と精密さを兼ね備えたプラスチック部品の製造を行っています。<br><br>
                        私たちは、クラス10000/100000のクリーンルーム環境で射出成形を行い、高い衛生基準を満たす抗菌部品を製造しています。部品にはFDA規格の材料を使用し、医療機器メーカーの厳格な品質基準をクリアしました。また、精密検査を全数実施し、信頼性の高い製品を提供。これにより、多くの医療機関で使用される機器に採用され、感染リスク低減に寄与しています。
                    </p>
                </li>
                <li class="development_works_item">
                    <img src="<?php echo_img(('development_img_works2.jpg')) ?>" alt="" class="development_works_img">
                    <p class="development_works_head">環境配慮型プラスチック製品の<br class="hp_nonePc">開発と製造</p>
                    <p class="development_works_text">
                        世界的な環境意識の高まりを受け、企業には持続可能な製品の提供が求められています。緑川化成工業は、プラスチックの再資源化技術を活かし、大手消費財メーカーと協力して、環境負荷を大幅に削減した製品を開発・製造しています。<br><br>
                        私たちは、使用済みプラスチックを再資源化し、その70%以上を製品に活用することに成功しました。ISO14001認証を取得した工場で生産されるこれらの製品は、性能を保ちながらも環境への負荷を軽減。特に、耐久性や加工性に優れたリサイクルプラスチック製品は、消費財メーカーのパッケージや日用品として採用され、循環型社会の実現に大きく貢献しています。
                    </p>
                </li>
                <li class="development_works_item">
                    <img src="<?php echo_img(('development_img_works3.jpg')) ?>" alt="" class="development_works_img">
                    <p class="development_works_head">環境配慮型プラスチック製品の<br class="hp_nonePc">開発と製造</p>
                    <p class="development_works_text">
                        世界的な環境意識の高まりを受け、企業には持続可能な製品の提供が求められています。緑川化成工業は、プラスチックの再資源化技術を活かし、大手消費財メーカーと協力して、環境負荷を大幅に削減した製品を開発・製造しています。<br><br>
                        私たちは、使用済みプラスチックを再資源化し、その70%以上を製品に活用することに成功しました。ISO14001認証を取得した工場で生産されるこれらの製品は、性能を保ちながらも環境への負荷を軽減。特に、耐久性や加工性に優れたリサイクルプラスチック製品は、消費財メーカーのパッケージや日用品として採用され、循環型社会の実現に大きく貢献しています。
                    </p>
                </li>
            </ul>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <section class="ly_section __gray">
        <div class="ly_container">
            <div class="bl_head3 __center">
                <span class="bl_head3_sub">緑川グループの製品</span>
                <h2 class="bl_head3_text">自社主力製品紹介</h2>
            </div>
            <ul class="development_products">
                <?php
                if (isset($_GET['keyword']) || isset($_GET['product_mk_categories'])) {
                    $paged = 1; // 検索時にページングを1にリセット
                } else {
                    // 通常のページング
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                };
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 9,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'paged'          => $paged,
                    'meta_query'     => array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'product_category',
                            'value'   => '1',
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key'     => 'product_type',
                            'value'   => 'processing',
                            'compare' => '!=',
                        ),
                    ),
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post(); ?>
                        <li class="bl_product">
                            <a href="<?php the_permalink(); ?>" class="bl_product_link">
                                <div class="bl_product_imgWrap">
                                    <?php if (isset(get_field('product_image1')["url"])): ?>
                                        <img src="<?php echo get_field('product_image1')["url"] ?>" alt="">
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/noimage.jpg" alt="">
                                    <?php endif; ?>
                                </div>
                                <p class="bl_product_head"><?php the_title(); ?></p>
                                <p class="bl_product_text">
                                    <?php echo nl2br(esc_html(get_field('product_overview'))); ?>
                                </p>
                                <ul class="bl_labelUnit __small">
                                    <?php
                                    $selected_categories = get_field('product_category');
                                    if ($selected_categories) {
                                        foreach ($selected_categories as $category) {
                                            echo '<li class="el_label __small">' . ListItems::getProductCategoryName($category) . '</li>';
                                        };
                                    };
                                    $selected_mk_categories = get_field('product_mk_category');
                                    if ($selected_mk_categories) {
                                        foreach ($selected_mk_categories as $mk) {
                                            echo '<li class="el_label __small">' . 'MK:' . ListItems::getProductMkCategoryName($mk) . '</li>';
                                        };
                                    };
                                    $selected_tags = get_field('product_tag');
                                    if ($selected_tags) {
                                        foreach ($selected_tags as $tag) {
                                            echo '<li class="el_label __small">' . '#' . ListItems::getProductTagName($tag) . '</li>';
                                        };
                                    };
                                    ?>
                                </ul>
                            </a>
                        </li>
                <?php endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
            <div class="development_products_btn">
                <a href="<?php echo get_url(Page::PRODUCTS) ?>" class="el_btn __type2 __wide">その他の製品</a>
            </div>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <section class="ly_section __pB">
        <div class="ly_container __mx962">
            <div class="bl_head3">
                <span class="bl_head3_sub">アクリルメーカーとしての強み</span>
                <h2 class="bl_head3_text">お客様のニーズを形に、価値を未来へ。</h2>
            </div>
            <p class="development_featureText">
                緑川グループは、これまで総合商社として多くのお客様と関わる中で培った「多様なニーズをくみ取る力」を活かし、メーカーとして独自の価値を提供しています。お客様との綿密なヒアリングを通じて課題や要望を深く理解し、その声をもとにした商品開発を推進。これにより、単なる製品供給を超えた、「お客様の想いを形にする」メーカーとしての強みを築き上げています。
            </p>
            <img src="<?php echo_img(('development_img_feature.jpg')) ?>" alt="" class="development_featureImg">
            <div class="development_featureWrap">
                <div class="development_featureWrap_headWrap">
                    <span class="development_featureWrap_subHead">( Our Provided Value )</span>
                    <h3 class="development_featureWrap_head">
                        緑川化成は<br class="hp_noneSp">メーカーとして<br>5つの価値を<br class="hp_noneSp">提供します
                    </h3>
                </div>
                <ul class="development_featureWrap_list">
                    <li class="development_featureWrap_item">
                        <div class="development_featureWrap_subjectWrap">
                            <span class="development_featureWrap_number">( 01 )</span>
                            <p class="development_featureWrap_subject">顧客ニーズをくみとる<br class="hp_nonePc">「<span>ヒアリング力</span>」</p>
                        </div>
                        <p class="development_featureWrap_text">
                            お客様一人ひとりの要望を丁寧にヒアリングし、それを製品として具体化する力が緑川の最大の強みです。市場の変化や多様なニーズに応える柔軟性と創造性を提供します。
                        </p>
                    </li>
                    <li class="development_featureWrap_item">
                        <div class="development_featureWrap_subjectWrap">
                            <span class="development_featureWrap_number">( 02 )</span>
                            <p class="development_featureWrap_subject">ニーズを実現する<br class="hp_nonePc">「<span>カスタマイズ力</span>」</p>
                        </div>
                        <p class="development_featureWrap_text">
                            お客様の声を丁寧にヒアリングし、その想いを反映した最適な仕様へとカスタマイズ。<br class="hp_noneSp">用途や環境に応じて細やかに調整を重ね、唯一無二の製品として具体化。市場の変化や多様なニーズに柔軟かつ確実に応える技術力を提供します。
                        </p>
                    </li>
                    <li class="development_featureWrap_item">
                        <div class="development_featureWrap_subjectWrap">
                            <span class="development_featureWrap_number">( 03 )</span>
                            <p class="development_featureWrap_subject">環境と未来を考えた<br class="hp_nonePc">「<span>サステナビリティ</span>」</p>
                        </div>
                        <p class="development_featureWrap_text">
                            緑川グループは、リサイクルアクリル板「リアライト®」をはじめとする環境配慮型製品を提供し、持続可能な社会の実現に貢献しています。しかし、私たちの取り組みは製品をつくることだけにとどまりません。使用後の製品を回収し、再原料化・再製品化することで、資源を循環させる独自のリサイクルシステムを確立。廃棄物を新たな価値へと生まれ変わらせ、限りある資源を未来へつなげていきます。
                        </p>
                    </li>
                    <li class="development_featureWrap_item">
                        <div class="development_featureWrap_subjectWrap">
                            <span class="development_featureWrap_number">( 04 )</span>
                            <p class="development_featureWrap_subject">設計から施工、そして<br class="hp_nonePc">再生まで一貫対応する<br class="hp_nonePc"><br class="hp_noneSp">「<span>トータルソリューション</span>」</p>
                        </div>
                        <p class="development_featureWrap_text">
                            単に製品を提供するのではなく、素材選定から設計、加工、施工、さらには使用後の回収・再生までを一貫して対応できる体制を整えています。これにより、お客様のニーズに柔軟に応えながら、資源の循環まで考えた「持続可能なものづくり」を実現。製品のライフサイクル全体を見据えたソリューションで、社会と環境に貢献し続けます。
                        </p>
                    </li>
                    <li class="development_featureWrap_item">
                        <div class="development_featureWrap_subjectWrap">
                            <span class="development_featureWrap_number">( 05 )</span>
                            <p class="development_featureWrap_subject">市場をリードする<br class="hp_nonePc">「<span>独自商品と技術力</span>」</p>
                        </div>
                        <p class="development_featureWrap_text">
                            独自開発の製品や高度な加工技術で、他にはないオリジナリティを提供。<br class="hp_noneSp">業界の先駆者として新しい価値を創出します。
                        </p>
                    </li>
                </ul>
            </div>
            <!-- /.development_featureWrap -->
            <div class="development_group">
                <div class="bl_head3">
                    <span class="bl_head3_sub">グループシナジー</span>
                    <h2 class="bl_head3_text">
                        緑川グループ11社と<br>協力会社3,000社の<br class="hp_nonePc">連携が生むシナジー
                    </h2>
                </div>
                <div class="development_group_inner">
                    <div class="development_group_imgWrap">
                        <img src="<?php echo_img(('development_img_group.svg')) ?>" alt="企画 デザイン 設計 制作 施工 組立 ロジスティクス 物流 原料 開発 調査">
                    </div>
                    <p class="development_group_text">
                        緑川グループは、11社のグループ企業と3,000社以上の協力会社が連携し、製品開発から製造、施工、アフターサポートまで一貫したサービスを提供しています。この広範なネットワークにより、各分野で培った専門技術を活かした高度なソリューションを実現。例えば、医療や工業、環境分野での製品開発から現場での施工管理まで、すべてをシームレスに対応します。また、グループ内の協力体制により、多様なニーズに柔軟かつ迅速に応え、品質と効率の両立を実現。お客様に信頼されるトータルサポートを通じて、より良い未来を共に創造します。
                    </p>
                </div>
            </div>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <section class="ly_section __color">
        <div class="ly_container __mx950">
            <div class="bl_head3">
                <span class="bl_head3_sub">品質管理ポリシー</span>
                <h2 class="bl_head3_text">品質に対する<br class="hp_nonePc">緑川グループの約束</h2>
            </div>
            <p class="development_policyText">
                緑川グループは、「品質第一」の理念のもと全ての製品に対して責任を持ちます。
            </p>
            <dl class="development_policy">
                <div class="development_policy_row">
                    <span class="development_policy_number">( 01 )</span>
                    <dt class="development_policy_head">
                        認証取得と<br class="hp_noneSp">基準への適合
                    </dt>
                    <dd class="development_policy_content">
                        <p>
                            ISO14001認証やFDA規格対応など、国際基準を満たす取り組みにより、高い品質を維持しています。
                        </p>
                        <img src="<?php echo_img(('img_policy.png')) ?>" alt="ISO1 4001 ENVIRONMENTAL SYSTEM JQA-EM3386">
                    </dd>
                </div>
                <div class="development_policy_row">
                    <span class="development_policy_number">( 02 )</span>
                    <dt class="development_policy_head">
                        徹底した<br class="hp_noneSp">品質管理体制
                    </dt>
                    <dd class="development_policy_content">
                        <p>
                            最新設備を活用した精密検査と、全数検査の徹底により、高い信頼性と安全性を保証しています。品質への妥協を許さない姿勢が、私たちの誇りです。
                        </p>
                    </dd>
                </div>
                <div class="development_policy_row">
                    <span class="development_policy_number">( 03 )</span>
                    <dt class="development_policy_head">
                        専門チームに<br class="hp_noneSp">よる品質保証
                    </dt>
                    <dd class="development_policy_content">
                        <p>
                            専任の品質保証チームが製品の設計段階から出荷後まで、一貫して品質を管理しています。お客様からのフィードバックを迅速に製品改良へ反映させることで、常に高い信頼性と顧客満足度を追求しています。
                        </p>
                    </dd>
                </div>
            </dl>
        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>