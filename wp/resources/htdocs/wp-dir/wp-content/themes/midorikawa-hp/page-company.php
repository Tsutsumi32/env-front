<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( Company )</span>
            <h1 class="bl_secondPageHead_head">会社情報</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="company_img">
        <img src="<?php echo_img('company_img_intro.jpg') ?>" alt="">
    </div>

    <div class="ly_flexContainer">
        <div class="ly_flexSide">
            <ul class="bl_anchorLink hp_noneSp">
                <li class="bl_anchorLink_item js_anchorLink is_active">
                    <a href="#company-message" class="bl_anchorLink_link">代表挨拶</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#company-philosophy" class="bl_anchorLink_link">企業理念</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#company-guide" class="bl_anchorLink_link">行動指針</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#company-outline" class="bl_anchorLink_link">会社概要</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#company-history" class="bl_anchorLink_link">沿革</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#company-group" class="bl_anchorLink_link">グループ会社紹介</a>
                </li>
            </ul>
            <!-- /.bl_anchorLink -->
        </div>
        <div class="ly_flexInner">
            <section class="ly_section __pB js_anchorLinkTarget" id="company-message">
                <div class="ly_container">
                    <div class="bl_selectWrap hp_nonePc js_accordionParent">
                        <p class="bl_selectWrap_head">Category</p>
                        <button type="button" class="bl_selectWrap_btn js_selectText js_accordionBtn">
                            代表挨拶
                        </button>
                        <ul class="bl_select js_accordionContents">
                            <li class="bl_select_item">
                                <a href="#company-message" class="bl_select_link js_accordionItem js_selectTextItem">代表挨拶</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#company-philosophy" class="bl_select_link js_accordionItem js_selectTextItem">企業理念</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#company-guide" class="bl_select_link js_accordionItem js_selectTextItem">行動指針</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#company-outline" class="bl_select_link js_accordionItem js_selectTextItem">会社概要</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#company-history" class="bl_select_link js_accordionItem js_selectTextItem">沿革</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#company-group" class="bl_select_link js_accordionItem js_selectTextItem">グループ会社紹介</a>
                            </li>
                        </ul>
                    </div>
                    <div class="bl_head3">
                        <span class="bl_head3_sub">代表ご挨拶</span>
                        <h2 class="bl_head3_text __nowrap">お客様と共に未来を創る、<br>緑川グループの挑戦</h2>
                    </div>
                    <div class="company_message">
                        <div class="company_message_textWrap">
                            <p class="company_message_text">
                                1954年(昭和29年)10月、再生アクリル板メーカーとして発足いたしました当社は、プラスチックの総合商社としてトップクラスの経験と実績を重ね、現在では様々な素材の販売に加え、デザイン・加工・施工会社やロジ会社など海外を含めグループ会社は11社、拠点数は２２箇所を数えております。<br>この様な当社の業務の拡がりは、世の中の動向や要望に従い貢献することが会社の存在意義と考え、推進してきたことによるものです。お客様からのあらゆる目的や課題に対し、一緒に考え、悩み、解決していく　私たち緑川グループは、そんな「人間集団」でありたいと思っております。今後も関連会社と協力しながら、お客様のあらゆるご要望にワンストップでお応えできる能力をさらに身に付け、ご提案できるよう努めて参ります。<br><br>全社員の一層の努力をお約束いたしますとともに、皆様の変わらぬご指導ご鞭撻のほど、よろしくお願い申し上げます。
                            </p>
                            <div class="company_message_nameWrap">
                                <p class="company_message_job">代表取締役社長</p>
                                <p class="company_message_name">緑川 忠男</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <section class="ly_section __color js_anchorLinkTarget" id="company-philosophy">
                <div class="ly_container">
                    <div class="bl_head3 __noPcMb">
                        <span class="bl_head3_sub">企業理念</span>
                        <h2 class="bl_head3_text __bg">-大きな心と大調和-</h2>
                    </div>
                    <p class="company_philosophy">
                        空間と時間軸を大きく捉えることで視野を広げ、事業活動を行います。<br class="hp_noneSp">心温まる人間集団と空間、時間の創造に努力します。
                    </p>
                    <div class="company_guide js_anchorLinkTarget" id="company-guide">
                        <div class="bl_head3 __noPcMb">
                            <span class="bl_head3_sub">行動指針</span>
                            <h2 class="bl_head3_text __bg __small">公共愛は<br class="hp_nonePc">社会を発展させる</h2>
                        </div>
                        <ul class="company_guide_list">
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 01 )</span>
                                <p class="company_guide_text">
                                    報恩、感謝の心を持って仕事しよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 02 )</span>
                                <p class="company_guide_text">
                                    愉しく仕事しよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 03 )</span>
                                <p class="company_guide_text">
                                    縁あり働く者同士、協力して相乗効果を生み出し、社会貢献の最大化に努めよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 04 )</span>
                                <p class="company_guide_text">
                                    どんな時もチャンス！<br>社会の要望、課題、夢に寄り添い、前向きな姿勢で社会と一体感のある仕事に努めよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 05 )</span>
                                <p class="company_guide_text">
                                    日本の育んできた思いやりある心と言葉を大切に、コミュニケーションを図り、節度と活気ある職場の実現に努めよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 06 )</span>
                                <p class="company_guide_text">
                                    日本は資源輸入国。<br>他国から譲って頂いた資源を無駄なく何度も使用するよう努めよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 07 )</span>
                                <p class="company_guide_text">
                                    役職は役割であり身分の上下でもなく、特権でもない。<br>皆の協力で良き運営に努めよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 08 )</span>
                                <p class="company_guide_text">
                                    自責でものごとを捉え、多くの視点を育もう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 09 )</span>
                                <p class="company_guide_text">
                                    働く人々は会社にとって掛け替えのないパートナーであり、働く人々にとって会社は社会貢献とやり甲斐、生活の糧を得る居場所である。<br>双方が「宝」と思い、幸福感のある職場づくりに努めよう
                                </p>
                            </li>
                            <li class="company_guide_item">
                                <span class="company_guide_number">( 10 )</span>
                                <p class="company_guide_text">
                                    健全な身体に健全な精神は宿る。両親から頂いた身体を大切に守っていこう
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <section class="ly_section __gray js_anchorLinkTarget" id="company-outline">
                <div class="ly_container">
                    <div class="company_flexWrap">
                        <div class="company_flexWrap_fix">
                            <div class="bl_head3">
                                <span class="bl_head3_sub">基本情報</span>
                                <h2 class="bl_head3_text">会社概要</h2>
                            </div>
                        </div>
                        <div class="company_flexWrap_contents">
                            <dl class="company_outline">
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">商号</dt>
                                    <dd class="company_outline_content">
                                        緑川化成工業株式会社
                                    </dd>
                                </div>
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">所在地</dt>
                                    <dd class="company_outline_content">
                                        〒111-0043<br>東京都台東区駒形1-4-18支店
                                    </dd>
                                </div>
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">創立</dt>
                                    <dd class="company_outline_content">
                                        1953年
                                    </dd>
                                </div>
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">設立</dt>
                                    <dd class="company_outline_content">
                                        1954年10月
                                    </dd>
                                </div>
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">資本金</dt>
                                    <dd class="company_outline_content">
                                        1億円
                                    </dd>
                                </div>
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">事業内容</dt>
                                    <dd class="company_outline_content">
                                        プラスチック板、プラスチック加工品及びプラスチック関連商品、成形材料、機械・工具の販売、用途開発
                                    </dd>
                                </div>
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">役員</dt>
                                    <dd class="company_outline_content">
                                        代表取締役 　緑川 忠男<br>
                                        取締役 　　　　渡辺 元行<br>
                                        取締役 　　　　安藤 敏則<br>
                                        取締役 　　　　堀内 彰
                                    </dd>
                                </div>
                                <div class="company_outline_row">
                                    <dt class="company_outline_head">取引銀行</dt>
                                    <dd class="company_outline_content">
                                        みずほ銀行（浅草支店）<span class="hp_noneSpInline">、</span><br class="hp_nonePc">りそな銀行（浅草支店）<span class="hp_noneSpInline">、</span><br>商工組合中央金庫（上野支店）<span class="hp_noneSpInline">、</span><br class="hp_nonePc">三井住友銀行（東京中央支店）
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <!-- /.company_flexWrap -->
                    <div class="company_flexWrap js_anchorLinkTarget" id="company-history">
                        <div class="company_flexWrap_fix">
                            <div class="bl_head3">
                                <span class="bl_head3_sub">沿革</span>
                                <h2 class="bl_head3_text">会社の歴史</h2>
                            </div>
                        </div>
                        <div class="company_flexWrap_contents">
                            <dl class="company_history">
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1954年10月</dt>
                                    <dd class="company_history_content">東京都台東区浅草に緑川樹脂株式会社を資本金100万円で設立。<br>アクリルシート「ミドリライト」の製造販売に着手。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1954年11月</dt>
                                    <dd class="company_history_content">千葉県松戸市上矢切に松戸工場を新設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1958年 1月</dt>
                                    <dd class="company_history_content">大阪市生野区に大阪支店を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1959年 7月</dt>
                                    <dd class="company_history_content">緑川化成工業株式会社に商号を変更。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1967年 6月</dt>
                                    <dd class="company_history_content">横浜市西区に横浜営業所を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1973年 9月</dt>
                                    <dd class="company_history_content">東京都台東区駒形に本社ビルを竣工。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1975年 6月</dt>
                                    <dd class="company_history_content">福岡市博多区に福岡営業所（現：九州事業所）を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1977年 6月</dt>
                                    <dd class="company_history_content">横浜市神奈川区に横浜営業所を移転。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1979年 4月</dt>
                                    <dd class="company_history_content">大阪市生野区に大阪支店新社屋を完成。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1980年 5月</dt>
                                    <dd class="company_history_content">福岡市東区に福岡営業所新社屋を完成、移転。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1982年12月</dt>
                                    <dd class="company_history_content">資本金1億円に増資。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1988年 4月</dt>
                                    <dd class="company_history_content">東京都墨田区業平に業平ストックセンターを開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1990年 3月</dt>
                                    <dd class="company_history_content">名古屋市中川区に名古屋営業所を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1990年 6月</dt>
                                    <dd class="company_history_content">北九州市小倉北区に北九州営業所を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1990年 8月</dt>
                                    <dd class="company_history_content">横浜営業所新社屋を完成。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1991年 8月 </dt>
                                    <dd class="company_history_content">本社所在地にムーブ株式会社を設立、福岡県苅田町に新工場を完成。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1992年 2月</dt>
                                    <dd class="company_history_content">本社所在地にアステックス株式会社を設立。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1995年11月</dt>
                                    <dd class="company_history_content">北九州出張所を営業所に昇格。北九州市小倉南区に新社屋完成。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1997年 4月</dt>
                                    <dd class="company_history_content">名古屋市中川区富田町に名古屋営業所新社屋を完成。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1997年 5月</dt>
                                    <dd class="company_history_content">千葉県松戸市に松戸ストックセンターを完成。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1998年 2月</dt>
                                    <dd class="company_history_content">仙台市宮城野区に仙台営業所を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">1999年 3月</dt>
                                    <dd class="company_history_content">静岡市に静岡営業所を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2001年10月 </dt>
                                    <dd class="company_history_content">本社所在地にシーシービー株式会社を設立。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2002年 1月</dt>
                                    <dd class="company_history_content">中国上海市に上海事業所を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2003年 5月</dt>
                                    <dd class="company_history_content">シーシービー株式会社がISO9001認証を取得。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2003年 6月</dt>
                                    <dd class="company_history_content">中国上海市に碧川化成貿易（上海）有限公司を設立。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2003年 9月</dt>
                                    <dd class="company_history_content">ISO14001認証を取得。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2003年12月</dt>
                                    <dd class="company_history_content">シーシービー株式会社がISO14001認証を取得。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2004年10月</dt>
                                    <dd class="company_history_content">中国張家港市に克蕾璐光電有限公司を設立、工場竣工。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2006年 2月</dt>
                                    <dd class="company_history_content">松戸ストックセンター敷地内に、加工センターを完成。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2006年 4月</dt>
                                    <dd class="company_history_content">張家港克蕾璐光電有限公司がISO14001認証を取得。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2007年12月</dt>
                                    <dd class="company_history_content">本社所在地に物流部門の分社化としてグリーンロジ株式会社を設立。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2010年10月</dt>
                                    <dd class="company_history_content">本社所在地にディーシーインターナショナル株式会社を設立。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2010年10月</dt>
                                    <dd class="company_history_content">中国上海市に迪茜(上海)展示設計有限公司を設立。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2013年10月</dt>
                                    <dd class="company_history_content">シーシービー藤岡工場を開設、射出成型事業開始。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2015年 4月</dt>
                                    <dd class="company_history_content">松戸ストックセンター増設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2015年 8月</dt>
                                    <dd class="company_history_content">シーシービー戸田工場を開設、金属加工及び木工製品の内作開始。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2016年11月</dt>
                                    <dd class="company_history_content">シーシービー磐田工場を開設、射出成型による車両用品の製造開始。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2019年12月</dt>
                                    <dd class="company_history_content">アステックス浜野工場を開設。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2022年4月</dt>
                                    <dd class="company_history_content">ルーサイト・ジャパンの全株を取得しグループ化。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2023年4月</dt>
                                    <dd class="company_history_content">経済産業省及び環境省より『プラスチックに係る資源循環の促進等に関する法律』に基づく自主回収・再資源化事業計画の第1号認定を受ける。</dd>
                                </div>
                                <!-- /.company_history_item -->
                                <div class="company_history_item js_historyContents">
                                    <dt class="company_history_head">2023年7月</dt>
                                    <dd class="company_history_content">伸和株式会社の全株を取得しグループ化。</dd>
                                </div>
                                <!-- /.company_history_item -->
                            </dl>
                            <button class="company_history_moreBtn js_historyBtn">すべて見る</button>
                        </div>
                    </div>
                    <!-- /.company_flexWrap -->
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <section class="ly_section __pB js_anchorLinkTarget" id="company-group">
                <div class="ly_container">
                    <div class="bl_head3">
                        <span class="bl_head3_sub">グループ会社紹介</span>
                    </div>
                    <div class="company_group">
                        <h3 class="el_labelHead">国内</h3>
                        <ul class="company_group_list">
                            <li class="company_group_item">
                                <p class="company_group_head">アステックス株式会社</p>
                                <img src="<?php echo_img('company_img_group_jp1.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    住空間、商業空間など建築分野にプラスチックの可能性を求めるなど、常にプラスチックの用途開発、新規市場の開拓に挑戦しています。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>アステックス株式会社</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>〒111-0043<br>東京都台東区駒形1-4-18緑川ビル8階</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>TEL 03-5828-5655(代表)</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>5,000万円</p>
                                        </dd>
                                    </div>
                                </dl>
                                <a href="http://www.astaix.co.jp/" target="_blank" rel="noopener noreferrer" class="company_group_btn">
                                    アステックス株式会社 WEBサイト
                                </a>
                            </li>
                            <li class="company_group_item">
                                <p class="company_group_head">シーシービー株式会社</p>
                                <img src="<?php echo_img('company_img_group_jp2.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    人工大理石製インテリア製品の設計から製造・施工までをトータルにサポート。また、POP、ディスプレイ製品の設計・製作や個店直送、ロジスティックスにも対応し、家具製作も承ります。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>シーシービー株式会社</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>〒111-0043<br>東京都台東区駒形1-4-18</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>TEL 03-5830-1431(代表)</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>5,000万円（資本構成 緑川化成工業（株）100%）</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">認証</dt>
                                        <dd class="company_group_outline_content">
                                            <p>ISO9001/ISO14001</p>
                                            <img src="<?php echo_img('company_icon_group_jp2_iso.png') ?>" alt="">
                                        </dd>
                                    </div>
                                </dl>
                                <a href="https://ccb-inc.jp/" target="_blank" rel="noopener noreferrer" class="company_group_btn">
                                    シーシービー株式会社 WEBサイト
                                </a>
                            </li>
                            <li class="company_group_item __mt">
                                <p class="company_group_head">ムーブ株式会社</p>
                                <img src="<?php echo_img('company_img_group_jp3.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    看板・銘板・表示板・グラフィックパネルの製作及び取り付け、プラスチックの真空成形加工、スクリーン印刷、半導体製造関連機器（洗浄ドラフト、クリンベンチ、デシケーター等）の製作を行っております。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>ムーブ株式会社</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>〒111-0043<br>東京都台東区駒形1-4-18</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>TEL 03-3844-1521(代表)</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>5,000万円</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">認証</dt>
                                        <dd class="company_group_outline_content">
                                            <p>ISO14001<br>苅田工場　認証範囲：<br>プラスチック材の成形及び加工</p>
                                            <img src="<?php echo_img('company_icon_group_jp3_iso.png') ?>" alt="">
                                        </dd>
                                    </div>
                                </dl>
                                <a href="http://www.move-ss150.co.jp/" target="_blank" rel="noopener noreferrer" class="company_group_btn">
                                    ムーブ株式会社 WEBサイト
                                </a>
                            </li>
                            <li class="company_group_item">
                                <p class="company_group_head">ディーシーインターナショナル<br>株式会社</p>
                                <img src="<?php echo_img('company_img_group_jp4.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    ディスプレイツールから店舗デザインまでの企画・設計・施工業務を担当致します。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>ディーシーインターナショナル株式会社</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>〒111-0043<br>東京都台東区駒形1-2-6緑川第二ビル5階</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>TEL 03-3844-1026(代表)</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>2,000万円</p>
                                        </dd>
                                    </div>
                                </dl>
                                <a href="http://www.dc-international.co.jp/" target="_blank" rel="noopener noreferrer" class="company_group_btn __wide __small">
                                    ディーシーインターナショナル株式会社 WEBサイト
                                </a>
                            </li>
                            <li class="company_group_item __mt">
                                <p class="company_group_head">グリーンロジ株式会社</p>
                                <img src="<?php echo_img('company_img_group_jp5.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    2m×4mの大型版の裁断を可能とするカッティングセンター。部材から完成品までの幅広い製品製作を担当しています。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>グリーンロジ株式会社</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>〒111-0043<br>東京都台東区駒形1-4-18</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>TEL 03-3844-1521(代表)</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>1,000万円</p>
                                        </dd>
                                    </div>
                                </dl>
                            </li>
                            <li class="company_group_item">
                                <p class="company_group_head">ルーサイト・ジャパン<br class="hp_noneSp">株式会社</p>
                                <img src="<?php echo_img('company_img_group_jp6.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    店舗、住宅水廻り製品（キッチンワークトップ、浴槽、洗面等）で使用されるアクリル系人工大理石用の原材料の用途開発、製造販売を行っております。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>ルーサイト・ジャパン株式会社</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>〒111-0043<br>東京都台東区駒形1-4-18緑川ビル3階</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>TEL 03-6770-6116(代表)</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>1億円</p>
                                        </dd>
                                    </div>
                                </dl>
                            </li>
                            <li class="company_group_item">
                                <p class="company_group_head">伸和株式会社</p>
                                <img src="<?php echo_img('company_img_group_jp7.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    プラスチックの板加工を主体に、半導体製造装置の部品、電気関係のカバー及び樹脂の機械加工・成形加工等を行い、機械加工だけでは出来ない特殊な加工は、創業当初から蓄積した経験と実績を生かし、確かな手加工でお応えいたします。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>伸和株式会社</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>本社 ：〒111-0043<br>東京都台東区駒形1-4-18</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>7,000万円</p>
                                        </dd>
                                    </div>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="company_group">
                        <h3 class="el_labelHead">海外</h3>
                        <ul class="company_group_list">
                            <li class="company_group_item">
                                <p class="company_group_head __nowrap">碧川化成貿易（上海）有限公司</p>
                                <img src="<?php echo_img('company_img_group_other1.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    緑川化成工業株式会社が中国事業進出の為に設立した、100％独資の中国現地法人。 PMMA、PC、PVC、PET 、その他エンプラ各種シート、丸棒、パイプ素材の販売、 及び化粧品・文具、店舗等の各種ディスプレー、壁装飾シート、各種広告看板、日用品、 ノベルティなどの加工・制作販売を行っております。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>碧川化成貿易（上海）有限公司</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>郵便番号 200336<br>上海市長寧区娄山关路83号<br>新虹桥中心大厦1310室</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>+86-21-5206 6382（日本語対応）<br>+86-21-5206 6381（中国語対応）</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>USD 230,000</p>
                                        </dd>
                                    </div>
                                </dl>
                            </li>
                            <li class="company_group_item">
                                <p class="company_group_head">張家港クレール光電有限公司</p>
                                <img src="<?php echo_img('company_img_group_other2.jpg') ?>" alt="" class="company_group_img">
                                <p class="company_group_text">
                                    ・液晶モニタ用『導光板』、『拡散板』他、各種ＩＴ関連樹脂部品の生産<br>
                                    ・特殊樹脂板等高性能複合材料および建築材料の生産<br>
                                    ・廃棄プラスチックスの再利用<br>
                                    ・樹脂板の切削加工および射出成形加工<br>
                                    などを中国で行っている緑川化成の関連工場です。
                                </p>
                                <dl class="company_group_outline">
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">商号</dt>
                                        <dd class="company_group_outline_content">
                                            <p>張家港クレール光電有限公司</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">本社所在地</dt>
                                        <dd class="company_group_outline_content">
                                            <p>郵便番号 215600<br>中国 江蘇省張家港市楊舎鎮中興路131号</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">連絡先</dt>
                                        <dd class="company_group_outline_content">
                                            <p>TEL +86-512-5818 9031<br>FAX +86-512-5818 9032</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">資本金</dt>
                                        <dd class="company_group_outline_content">
                                            <p>USD 5,000,000</p>
                                        </dd>
                                    </div>
                                    <div class="company_group_outline_row">
                                        <dt class="company_group_outline_head">認証</dt>
                                        <dd class="company_group_outline_content">
                                            <p>ISO9001/ISO14001</p>
                                            <img src="<?php echo_img('company_icon_group_other2_iso.png') ?>" alt="">
                                        </dd>
                                    </div>
                                </dl>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->
        </div>
        <!-- /.ly_flexInner -->
    </div>
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>