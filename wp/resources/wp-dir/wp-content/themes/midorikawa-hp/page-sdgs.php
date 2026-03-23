<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( SDGs )</span>
            <h1 class="bl_secondPageHead_head">サステナビリティ</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <section class="ly_section __gray">
        <div class="ly_container">
            <div class="bl_head3 __noPcMb">
                <span class="bl_head3_sub">SDGsへの具体的な取り組み</span>
                <h2 class="bl_head3_text">未来を創る<br class="hp_nonePc">緑川グループの実践例</h2>
            </div>
            <p class="sdgs_intro">
                緑川グループでは、持続可能な社会の実現に向けた具体的な取り組みを進めています。<br>資源の循環利用や環境負荷の低減、地域社会との連携など、SDGs達成を目指した行動を紹介します。<br>私たちの活動を通じて、未来を支える新たな価値を創造していきます。
            </p>
            <section class="sdgs_section">
                <h3 class="el_labelHead __large">リサイクル・循環型社会や<br class="hp_nonePc">資源保全への取り組み</h3>
                <div class="sdgs_imgWrap">
                    <img src="<?php echo_img('sdgs_img_sdgs12.jpg') ?>" alt="12 つくる責任つかう責任">
                    <img src="<?php echo_img('sdgs_img_sdgs13.jpg') ?>" alt="13 気候変動に具体的な対策を">
                    <img src="<?php echo_img('sdgs_img_sdgs14.jpg') ?>" alt="14 海の豊かさを守ろう">
                    <img src="<?php echo_img('sdgs_img_sdgs15.jpg') ?>" alt="15 陸の豊かさも守ろう">
                </div>
                <ul class="sdgs_outline">
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">循環型社会への取り組み</p>
                        <div class="sdgs_outline_textWrap">
                            <p class="sdgs_outline_text">
                                日本は小資源国として、多くの資源を海外から輸入し、素材から製品まで製造し国内外で販売しています。しかし、これらの素材や製品は通常、役目を終えると廃棄されてしまうのが現状です。<br>緑川化成工業では、この大切な資源を無駄なく循環させることが持続可能な未来に欠かせないと考え、廃棄される前に回収・再生して新たな資源へと生まれ変わらせる「循環型リサイクル」を推進しています。再生された素材を用いて、さまざまな製品を生み出し、サステナブルな社会への貢献を目指しています。
                            </p>
                        </div>
                    </li>
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">MKブランド商品<br class="hp_nonePc">: 環境への配慮と高付加価値</p>
                        <div class="sdgs_outline_textWrap">
                            <p class="sdgs_outline_text">
                                緑川化成工業では、『高機能』『高品質』『高付加価値』を特徴とする製品を『MKブランド』として展開しています。その中でも特に注目されるのが、エコマークを取得した国内生産のリサイクルアクリル板「リアライトRE」。<br>この商品は、循環型社会実現の象徴とも言える製品です。<br>さらに、MKブランド以外の製品にもリサイクル素材を積極的に取り入れ、資源の有効活用を進めています。
                            </p>
                            <picture>
                                <source media="(max-width: <?php echo BREAK_PC ?>)" srcset="<?php echo_img('sdgs_img_brand_sp.png') ?>">
                                <img src="<?php echo_img('sdgs_img_brand.png') ?>" alt="MKブランド代表 『リアライト®』 再生率80％以上の国内生産アクリル板" class="sdgs_outline_rearlight">
                            </picture>
                        </div>
                    </li>
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">具体的な環境貢献</p>
                        <div class="sdgs_outline_textWrap __bk">
                            <p class="sdgs_outline_text __circle">
                                CO2排出量の削減<br>
                                環境に配慮した生産プロセスにより、二酸化炭素の排出を抑制します。
                            </p>
                            <p class="sdgs_outline_text __circle">
                                海洋ごみ削減<br>
                                リサイクル技術を活用し、マイクロプラスチックの発生源となる海洋ごみを削減します。
                            </p>
                            <p class="sdgs_outline_text __circle">
                                森林保全<br>
                                管理された森林からの木材を使用し、持続可能な調達を実現します。
                            </p>
                        </div>
                    </li>
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">情報発信</p>
                        <div class="sdgs_outline_textWrap __gap">
                            <p class="sdgs_outline_text">
                                緑川化成工業では、おおさかATCグリーンエコプラザの循環型社会形成推進ゾーン展示内に常設展示ブースを開設しました。このブースでは、循環型アクリル再生を中心に、当社のリサイクル活動や循環型社会実現への取り組みを紹介しています。また、飛沫防止パネルの回収プロジェクトをテーマに会員セミナーでプレゼンテーションを行い、具体的な取り組み内容を広く発信しています<br><br>
                                <span>おおさかATCグリーンエコプラザとは…</span><br>
                                おおさかATCグリーンエコプラザは、環境をテーマに企業、行政、学校、さらには海外からの見学団体に向けて、環境学習やセミナーを提供する常設展示場です。企業の展示製品やCSR活動の報告を通じて、最新の環境情報を発信しています。この施設は、環境イノベーションを促進する場として、未来の豊かな街づくりや国づくりに貢献しています。
                            </p>
                            <div class="sdgs_outline_img">
                                <img src="<?php echo_img('sdgs_img_information.jpg') ?>" alt="">
                            </div>
                        </div>
                    </li>
                </ul>
            </section>
            <!-- /.sdgs_section -->
            <section class="sdgs_section">
                <h3 class="el_labelHead __large">働きやすい職場づくり</h3>
                <div class="sdgs_imgWrap">
                    <img src="<?php echo_img('sdgs_img_sdgs5.jpg') ?>" alt="5 ジェンダー平等を表現しよう">
                    <img src="<?php echo_img('sdgs_img_sdgs8.jpg') ?>" alt="8 働きがいも経済成長も">
                    <img src="<?php echo_img('sdgs_img_sdgs10.jpg') ?>" alt="10 人や国の不平等をなくそう">
                </div>
                <ul class="sdgs_outline">
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">社員のワークライフバランスを<br class="hp_nonePc">支援する取り組み</p>
                        <div class="sdgs_outline_textWrap __bk">
                            <p class="sdgs_outline_text">
                                緑川化成工業では、社員が仕事と子育てを両立し、多様な働き方を実現できる環境づくりに取り組んでいます。
                            </p>
                            <p class="sdgs_outline_text __circle">
                                柔軟な働き方の提供<br>
                                時短勤務や在宅勤務を導入し、社員がライフステージに合わせて働ける仕組みを整備しています。
                            </p>
                            <p class="sdgs_outline_text __circle">
                                制度の周知と管理職への研修<br>
                                産前産後休業や育児休業の取得を促進するため、制度の周知や管理職向けの研修を実施しています。
                            </p>
                            <p class="sdgs_outline_text __circle">
                                業務の効率化<br>
                                業務の属人化を解消し、平準化・効率化を進めています。
                            </p>
                            <p class="sdgs_outline_text __circle">
                                所定外労働時間の削減<br>
                                残業の事前申請制を導入し、所定外労働時間の削減を推進しています。
                            </p>
                        </div>
                    </li>
                </ul>
            </section>
            <!-- /.sdgs_section -->
            <section class="sdgs_section">
                <h3 class="el_labelHead __large">多様な企業様との<br class="hp_nonePc">パートナーシップによる取り組み</h3>
                <div class="sdgs_imgWrap">
                    <img src="<?php echo_img('sdgs_img_sdgs17.jpg') ?>" alt="17 パートナーシップで目標を達成しよう">
                </div>
                <ul class="sdgs_outline">
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">アクリルのクローズド・リサイクルの推進</p>
                        <div class="sdgs_outline_textWrap">
                            <p class="sdgs_outline_text">
                                自社ブランドのリサイクルアクリル板「リアライト®」をご利用いただいている加工業者様や、「リアライト®」製品のユーザー様からの分別回収にご協力いただき、アクリルのクローズド・リサイクルを進めています。この取り組みを通じて、廃材を新たな資源として循環させ、SDGsの達成に貢献してまいります。
                            </p>
                        </div>
                    </li>
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">福祉工場との連携による再原料化</p>
                        <div class="sdgs_outline_textWrap">
                            <p class="sdgs_outline_text">
                                市場から回収した端材は、福祉工場の皆さんに依頼し、再原料化を進めています。この連携により、限りある資源を有効活用しながら、社会全体でリサイクル活動を支える仕組みを構築しています。
                            </p>
                        </div>
                    </li>
                </ul>
            </section>
            <!-- /.sdgs_section -->
            <section class="sdgs_section">
                <h3 class="el_labelHead __large">平和と公正のためのCSR指針</h3>
                <div class="sdgs_imgWrap">
                    <img src="<?php echo_img('sdgs_img_sdgs16.jpg') ?>" alt="16 平和と公正をすべての人に">
                </div>
                <ul class="sdgs_outline">
                    <li class="sdgs_outline_item">
                        <div class="sdgs_outline_textWrap">
                            <p class="sdgs_outline_text __noMt">
                                緑川化成工業では、CSRを果たすためのコーポレートガバナンスの一環として、グループ全体に対して緑川化成工業グループCSR指針を制定しています。CSR指針では以下のような内容（一部抜粋）を掲げ、チェックするよう定めています。<br><br>
                                ・強制的な労働、非人道的な労働の禁止<br>
                                ・児童労働の禁止<br>
                                ・差別の禁止<br>
                                ・汚職、賄賂や不適切な利益供与、その他自由で公正かつ透明な取引を阻害する行為の禁止<br>
                                ・法令等で規制される物質や技術に関する適切な輸出管理の実施
                            </p>
                        </div>
                    </li>
                </ul>
            </section>
            <!-- /.sdgs_section -->
            <section class="sdgs_section">
                <h3 class="el_labelHead __large">SDGsに関する活動の記録</h3>
                <ul class="sdgs_outline">
                    <li class="sdgs_outline_item">
                        <p class="sdgs_outline_head">緑川化成工業ではSDGs達成向けて様々な取り組みを行っています。</p>
                    </li>
                </ul>
                <ul class="sdgs_worksList">
                    <li class="sdgs_worksList_item js_modalOpen" data-modal="fukuoka">
                        <img src="<?php echo_img('sdgs_img_works1.png') ?>" alt="">
                        <p class="sdgs_worksList_text">福岡県SDGs登録事業者</p>
                    </li>
                    <li class="sdgs_worksList_item js_modalOpen" data-modal="kanagawa">
                        <img src="<?php echo_img('sdgs_img_works2.png') ?>" alt="">
                        <p class="sdgs_worksList_text">かながわSDGsパートナー</p>
                    </li>
                    <li class="sdgs_worksList_item js_modalOpen" data-modal="sagamihara">
                        <img src="<?php echo_img('sdgs_img_works3.png') ?>" alt="">
                        <p class="sdgs_worksList_text">さがみはらSDGsパートナー</p>
                    </li>
                    <li class="sdgs_worksList_item __disabled">
                        <img src="<?php echo_img('sdgs_img_works4.png') ?>" alt="">
                        <p class="sdgs_worksList_text">横浜市SDGs認証制度<br class="hp_nonePc">Y-SDGs</p>
                    </li>
                    <li class="sdgs_worksList_item js_modalOpen" data-modal="ishinomaki">
                        <img src="<?php echo_img('sdgs_img_works5.png') ?>" alt="">
                        <p class="sdgs_worksList_text">いしのまき圏域<br class="hp_nonePc">SDGsパートナー</p>
                    </li>
                </ul>
            </section>
            <!-- /.sdgs_section -->

        </div>
        <!-- /.ly_container -->
    </section>
    <!-- /.ly_section -->

    <div class="sdgs_modal js_modal" data-modal="fukuoka">
        <div class="sdgs_modal_bg js_modalClose"></div>
        <div class="sdgs_modal_contents">
            <button class="sdgs_modal_close js_modalClose"></button>
            <div class="sdgs_modal_inner js_modalScroll">
                <p class="sdgs_modal_head">緑川化成工業株式会社</p>
                <img src="<?php echo_img('img_sdgs_fukuoka.png') ?>" alt="" class="sdgs_modal_img">
                <p class="sdgs_modal_text">九州事業所は、福岡県により福岡県SDGs登録事業者として登録されました。</p>
            </div>
        </div>
    </div>

    <div class="sdgs_modal js_modal" data-modal="kanagawa">
        <div class="sdgs_modal_bg js_modalClose"></div>
        <div class="sdgs_modal_contents">
            <button class="sdgs_modal_close js_modalClose"></button>
            <div class="sdgs_modal_inner js_modalScroll">
                <p class="sdgs_modal_head">緑川化成工業株式会社</p>
                <img src="<?php echo_img('img_sdgs_kanagawa.jpg') ?>" alt="" class="sdgs_modal_img">
                <p class="sdgs_modal_text">横浜営業所は、神奈川県によりかながわSDGsパートナーとして登録されました。</p>
            </div>
        </div>
    </div>

    <div class="sdgs_modal js_modal" data-modal="sagamihara">
        <div class="sdgs_modal_bg js_modalClose"></div>
        <div class="sdgs_modal_contents">
            <button class="sdgs_modal_close js_modalClose"></button>
            <div class="sdgs_modal_inner js_modalScroll">
                <p class="sdgs_modal_head">緑川化成工業株式会社</p>
                <img src="<?php echo_img('img_sdgs_sagamihara.jpg') ?>" alt="" class="sdgs_modal_img">
                <p class="sdgs_modal_text">横浜営業所は、相模原市によりさがみはらSDGsパートナーとして登録されました。</p>
            </div>
        </div>
    </div>

    <div class="sdgs_modal js_modal" data-modal="ishinomaki">
        <div class="sdgs_modal_bg js_modalClose"></div>
        <div class="sdgs_modal_contents">
            <button class="sdgs_modal_close js_modalClose"></button>
            <div class="sdgs_modal_inner js_modalScroll">
                <p class="sdgs_modal_head">緑川化成工業株式会社</p>
                <img src="<?php echo_img('img_sdgs_ishinomaki.png') ?>" alt="" class="sdgs_modal_img">
                <p class="sdgs_modal_text">緑川化成工業(株)は、石巻市によりいしのまき圏域SDGsパートナーとして登録されました。いしのまき圏域SDGsパートナーについてはこちら<a href="https://www.city.ishinomaki.lg.jp/cont/10051050/1000/sdgs.html" target="_blank" rel="noopener noreferrer">（外部サイト）</a></p>
            </div>
        </div>
    </div>
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>