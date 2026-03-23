<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="ly_main">
    <div class="bl_secondPageHead">
        <?php require(get_theme_file_path('/inc/components/breadcrumbs.php')); ?>
        <div class="ly_container">
            <span class="bl_secondPageHead_sub">( RECRUIT )</span>
            <h1 class="bl_secondPageHead_head">採用情報</h1>
        </div>
    </div>
    <!-- /.bl_secondPageHead -->

    <div class="recruit_img">
        <img src="<?php echo_img('recruit_img_intro.jpg') ?>" alt="">
    </div>

    <div class="ly_flexContainer">
        <div class="ly_flexSide">
            <ul class="bl_anchorLink hp_noneSp">
                <li class="bl_anchorLink_item js_anchorLink is_active">
                    <a href="#recruit-message" class="bl_anchorLink_link">メッセージ</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#recruit-request" class="bl_anchorLink_link">求める人物像</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#recruit-training" class="bl_anchorLink_link">研修制度</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#recruit-interview" class="bl_anchorLink_link">先輩の声</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#recruit-benefit" class="bl_anchorLink_link">福利厚生について</a>
                </li>
                <li class="bl_anchorLink_item js_anchorLink">
                    <a href="#recruit-entry" class="bl_anchorLink_link">エントリーについて</a>
                </li>
            </ul>
            <!-- /.bl_anchorLink -->
        </div>
        <!-- /.ly_flexSide -->
        <div class="ly_flexInner">
            <section class="ly_section js_anchorLinkTarget" id="recruit-message">
                <div class="ly_container">
                    <div class="bl_selectWrap hp_nonePc js_accordionParent">
                        <p class="bl_selectWrap_head">Category</p>
                        <button type="button" class="bl_selectWrap_btn js_selectText js_accordionBtn">
                            メッセージ
                        </button>
                        <ul class="bl_select js_accordionContents">
                            <li class="bl_select_item">
                                <a href="#recruit-message" class="bl_select_link js_accordionItem js_selectTextItem">メッセージ</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#recruit-request" class="bl_select_link js_accordionItem js_selectTextItem">求める人物像</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#recruit-training" class="bl_select_link js_accordionItem js_selectTextItem">研修制度</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#recruit-interview" class="bl_select_link js_accordionItem js_selectTextItem">先輩の声</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#recruit-benefit" class="bl_select_link js_accordionItem js_selectTextItem">福利厚生について</a>
                            </li>
                            <li class="bl_select_item">
                                <a href="#recruit-entry" class="bl_select_link js_accordionItem js_selectTextItem">エントリーについて</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ly_container __spMax __noRight">
                    <div class="recruit_messageWrap">
                        <div class="recruit_messageWrap_textWrap">
                            <div class="bl_head3">
                                <span class="bl_head3_sub">メッセージ</span>
                                <h2 class="bl_head3_text">未来を創るのは、<br>自ら考え行動する力。</h2>
                            </div>
                            <div class="recruit_messageWrap_imgWrap hp_nonePc">
                                <img src="<?php echo_img('recruit_img_message.jpg') ?>" alt="">
                            </div>
                            <p class="recruit_messageWrap_message">
                                緑川化成工業は、<br>チャレンジ精神を持ち、<br class="hp_nonePc">積極的に変化を楽しむ人材を求めています。<br>私たちのモットーは、<br class="hp_nonePc">“自分で考えて行動し、積極的に変化する”こと。<br><br>社員一人ひとりが新しい価値を創造し、<br>持続可能な社会を支える存在になることを<br class="hp_nonePc">目指しています。
                            </p>
                        </div>
                        <div class="recruit_messageWrap_imgWrap hp_noneSp">
                            <img src="<?php echo_img('recruit_img_message.jpg') ?>" alt="">
                        </div>
                    </div>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <section class="ly_section __pB js_anchorLinkTarget" id="recruit-request">
                <div class="ly_container __noLeft">
                    <div class="recruit_requestWrap">
                        <div class="recruit_requestWrap_imgWrap">
                            <img src="<?php echo_img('recruit_img_request1.jpg') ?>" alt="">
                            <img src="<?php echo_img('recruit_img_request2.jpg') ?>" alt="">
                        </div>
                        <div class="recruit_requestWrap_textWrap">
                            <div class="bl_head3">
                                <span class="bl_head3_sub">求める人物像</span>
                                <h2 class="bl_head3_text">緑川化成工業に<br>マッチする人とは？</h2>
                            </div>
                            <ul class="recruit_requestWrap_textList">
                                <li class="recruit_requestWrap_textItem">
                                    <p class="recruit_requestWrap_textHead">自ら考え行動できる人</p>
                                    <p class="recruit_requestWrap_text">
                                        「自分で考えて行動し、積極的に変化する」というモットーを体現できる人材。課題解決に向けて自発的にアイデアを出し、行動に移せる主体性を持つことが求められます。
                                    </p>
                                </li>
                                <li class="recruit_requestWrap_textItem">
                                    <p class="recruit_requestWrap_textHead">チャレンジ精神旺盛な人</p>
                                    <p class="recruit_requestWrap_text">
                                        新しいことに積極的に挑戦し、困難な状況でも柔軟に対応できる人。変化を恐れず、新しい価値を創造する意欲を持つ人材が必要です。
                                    </p>
                                </li>
                                <li class="recruit_requestWrap_textItem">
                                    <p class="recruit_requestWrap_textHead">社会や環境への貢献意識を持つ人</p>
                                    <p class="recruit_requestWrap_text">
                                        循環型社会の実現やSDGs達成を目指す企業理念に共感し、環境問題や社会課題の解決に主体的に取り組む意識を持った人材。自分の仕事が社会に与える影響を考え、持続可能な未来に貢献する意志が求められます。
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <section class="ly_section __gray js_anchorLinkTarget" id="recruit-training">
                <div class="ly_container">
                    <div class="bl_head3 __noPcMb">
                        <span class="bl_head3_sub">緑川化成工業の研修制度</span>
                        <h2 class="bl_head3_text">人が価値を創り、<br class="hp_nonePc">未来を切り拓く。</h2>
                    </div>
                    <p class="recruit_trainingIntro">
                        緑川化成工業は、人こそが会社の宝であると考えています。<br class="hp_noneSp">だからこそ、人材ではなく「人財」として成長を支援する研修制度を充実させ、共に未来を創る力を育てています。
                    </p>
                    <ul class="recruit_trainingList">
                        <li class="recruit_trainingList_item">
                            <span class="recruit_trainingList_subject">( 入社直後 )</span>
                            <div class="recruit_trainingList_inner">
                                <div class="recruit_trainingList_textWrap">
                                    <h3 class="recruit_trainingList_head">
                                        新入社員研修
                                    </h3>
                                    <div class="recruit_trainingList_textWrapInner">
                                        <p class="recruit_trainingList_subHead">研修内容</p>
                                        <ul class="recruit_trainingList_trainingList __flex">
                                            <li class="recruit_trainingList_training">●会社の方針</li>
                                            <li class="recruit_trainingList_training">●ビジネスマナー</li>
                                            <li class="recruit_trainingList_training">●商品の基礎知識</li>
                                            <li class="recruit_trainingList_training">●工場・倉庫見学</li>
                                            <li class="recruit_trainingList_training">●オフコン研修</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="recruit_trainingList_item">
                            <span class="recruit_trainingList_subject">( 新入社員研修後 )</span>
                            <div class="recruit_trainingList_inner">
                                <div class="recruit_trainingList_textWrap">
                                    <h3 class="recruit_trainingList_head">現場研修</h3>
                                    <div class="recruit_trainingList_textWrapInner">
                                        <p class="recruit_trainingList_subHead">研修内容</p>
                                        <ul class="recruit_trainingList_trainingList">
                                            <li class="recruit_trainingList_training">●グループ企業での加工研修</li>
                                            <li class="recruit_trainingList_training">●倉庫での物流研修</li>
                                            <li class="recruit_trainingList_training">●各事業所ごとにOJT</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="recruit_trainingList_item">
                            <span class="recruit_trainingList_subject">( 部署配属後 )</span>
                            <div class="recruit_trainingList_inner">
                                <div class="recruit_trainingList_textWrap">
                                    <h3 class="recruit_trainingList_head">QC研修</h3>
                                    <div class="recruit_trainingList_textWrapInner">
                                        <p class="recruit_trainingList_subHead">研修内容</p>
                                        <ul class="recruit_trainingList_trainingList">
                                            <li class="recruit_trainingList_training">●品質改善活動の実践</li>
                                            <li class="recruit_trainingList_training">●業務の効率化・方針管理の推進</li>
                                            <li class="recruit_trainingList_training">●各部署の業務計画の作成</li>
                                            <li class="recruit_trainingList_training">●QCサークル活動の推進</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="recruit_trainingList_item">
                            <span class="recruit_trainingList_subject">( 入社3年目以降 )</span>
                            <div class="recruit_trainingList_inner">
                                <div class="recruit_trainingList_textWrap">
                                    <h3 class="recruit_trainingList_head">全社員研修</h3>
                                    <div class="recruit_trainingList_textWrapInner">
                                        <p class="recruit_trainingList_subHead">研修内容</p>
                                        <ul class="recruit_trainingList_trainingList">
                                            <li class="recruit_trainingList_training">●外部講師を招いての研修</li>
                                            <li class="recruit_trainingList_training">●各回のテーマに基づく研修</li>
                                            <li class="recruit_trainingList_training">●階層別に研修</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="recruit_trainingList_item">
                            <span class="recruit_trainingList_subject">( 毎年2回 )</span>
                            <div class="recruit_trainingList_inner">
                                <div class="recruit_trainingList_textWrap">
                                    <h3 class="recruit_trainingList_head">営業・業務研修</h3>
                                    <div class="recruit_trainingList_textWrapInner">
                                        <p class="recruit_trainingList_subHead">研修内容</p>
                                        <ul class="recruit_trainingList_trainingList">
                                            <li class="recruit_trainingList_training">●外部講師による講演</li>
                                            <li class="recruit_trainingList_training">●各事業所の目標発表</li>
                                            <li class="recruit_trainingList_training">●グループディスカッション</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="recruit_trainingList_item">
                            <span class="recruit_trainingList_subject">( 2年に一回 )</span>
                            <div class="recruit_trainingList_inner">
                                <div class="recruit_trainingList_textWrap">
                                    <h3 class="recruit_trainingList_head">研修旅行</h3>
                                    <div class="recruit_trainingList_textWrapInner">
                                        <p class="recruit_trainingList_subHead">研修内容</p>
                                        <ul class="recruit_trainingList_trainingList">
                                            <li class="recruit_trainingList_training">●モチベーションアップ</li>
                                            <li class="recruit_trainingList_training">●コミュニケーションの活性化</li>
                                            <li class="recruit_trainingList_training">●チームビルディング</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <section class="ly_section __color js_anchorLinkTarget" id="recruit-interview">
                <div class="ly_container">
                    <div class="bl_head3">
                        <span class="bl_head3_sub">先輩の声</span>
                        <h2 class="bl_head3_text">会社を支える<br class="hp_nonePc">先輩社員たちの声</h2>
                    </div>
                </div>
                <div class="ly_container __spMax __noRight">
                    <div class="recruit_interviewSliderParent">
                        <div class="recruit_interviewSlider js_interviewSlider swiper">
                            <ul class="recruit_interviewSlider_wrapper swiper-wrapper">
                                <li class="recruit_interviewSlider_slide swiper-slide">
                                    <p class="recruit_interviewSlider_head hp_nonePc">お客様に頼られたい</p>
                                    <div class="recruit_interviewSlider_imgWrap">
                                        <img src="<?php echo_img('recruit_img_interview1.jpg') ?>" alt="M.Sさんの写真">
                                    </div>
                                    <div class="recruit_interviewSlider_textWrap">
                                        <p class="recruit_interviewSlider_head hp_noneSp">お客様に頼られたい</p>
                                        <div class="recruit_interviewSlider_nameWrap">
                                            <p class="recruit_interviewSlider_name">
                                                営業第一部<br>（サイン看板、キーホルダー業界への資材販売）
                                            </p>
                                            <p class="recruit_interviewSlider_name">
                                                M.S（入社3年目）
                                            </p>
                                        </div>
                                        <p class="recruit_interviewSlider_text">
                                            会社の方針が私たちにも提示されるので、迷うことなく仕事ができます。<br>ベテランの先輩もそばにいるので、何かあれば皆で解決していけます。<br>お客様に名前を憶えていただける事が増えたので、<br clas>お客様に頼っていただけるようになりたいです。
                                        </p>
                                    </div>
                                </li>
                                <li class="recruit_interviewSlider_slide swiper-slide">
                                    <p class="recruit_interviewSlider_head __small hp_nonePc">先輩がキラキラしていました</p>
                                    <div class="recruit_interviewSlider_imgWrap">
                                        <img src="<?php echo_img('recruit_img_interview2.jpg') ?>" alt="R.Nさんの写真">
                                    </div>
                                    <div class="recruit_interviewSlider_textWrap">
                                        <p class="recruit_interviewSlider_head hp_noneSp">先輩がキラキラしていました</p>
                                        <div class="recruit_interviewSlider_nameWrap">
                                            <p class="recruit_interviewSlider_name">
                                                営業第二部（人工大理石、成形品の販売）
                                            </p>
                                            <p class="recruit_interviewSlider_name">
                                                R.N（入社9年目）
                                            </p>
                                        </div>
                                        <p class="recruit_interviewSlider_text">
                                            入社のきっかけは社員の方が会社について生き生きと話してくださったから。今もその印象は変わりません。環境はすごくいいです。<br>これからも入社される人たちがきちんと仕事ができて、長く勤められる環境を作っていきたいと思っています。
                                        </p>
                                    </div>
                                </li>
                                <li class="recruit_interviewSlider_slide swiper-slide">
                                    <p class="recruit_interviewSlider_head hp_nonePc">先輩が成長を見てくれる</p>
                                    <div class="recruit_interviewSlider_imgWrap">
                                        <img src="<?php echo_img('recruit_img_interview3.jpg') ?>" alt="M.Aさんの写真">
                                    </div>
                                    <div class="recruit_interviewSlider_textWrap">
                                        <p class="recruit_interviewSlider_head hp_noneSp">先輩が成長を見てくれる</p>
                                        <div class="recruit_interviewSlider_nameWrap">
                                            <p class="recruit_interviewSlider_name">
                                                営業第五部<br>（内装資材の販売、店舗什器の製作・取付施工）
                                            </p>
                                            <p class="recruit_interviewSlider_name">
                                                M.A（入社2年目）
                                            </p>
                                        </div>
                                        <p class="recruit_interviewSlider_text">
                                            見積りはお客様によって違い、マニュアル通りにはほとんどいきません。<br>でも先輩にすぐ相談できますし、フォローもしていただけます。一人で悩む方が良くないという雰囲気です。家族のように暖かく、自分から成長しようと思える会社です。
                                        </p>
                                    </div>
                                </li>
                                <li class="recruit_interviewSlider_slide swiper-slide">
                                    <p class="recruit_interviewSlider_head hp_nonePc">人間関係の悩みはゼロ！</p>
                                    <div class="recruit_interviewSlider_imgWrap">
                                        <img src="<?php echo_img('recruit_img_interview4.jpg') ?>" alt="N.Hさんの写真">
                                    </div>
                                    <div class="recruit_interviewSlider_textWrap">
                                        <p class="recruit_interviewSlider_head hp_noneSp">人間関係の悩みはゼロ！</p>
                                        <div class="recruit_interviewSlider_nameWrap">
                                            <p class="recruit_interviewSlider_name">営業第八部<br>（エンジニアリングプラスチック・工業製品）</p>
                                            <p class="recruit_interviewSlider_name">N.H（入社2年目）</p>
                                        </div>
                                        <p class="recruit_interviewSlider_text">
                                            先輩は何かあればすぐに声をかけてくれてたとえ失敗をしても怒らず、<br>何が悪かったのかをしっかり教えてくださいます。雰囲気が良くて長く続けたい会社です。<br>もし後輩ができたら今度は私が先輩のように教えたり助けたりしてあげたいです。
                                        </p>
                                    </div>
                                </li>
                                <li class="recruit_interviewSlider_slide swiper-slide">
                                    <p class="recruit_interviewSlider_head hp_nonePc">社内を支える部署です！</p>
                                    <div class="recruit_interviewSlider_imgWrap">
                                        <img src="<?php echo_img('recruit_img_interview5.jpg') ?>" alt="K.Tさんの写真">
                                    </div>
                                    <div class="recruit_interviewSlider_textWrap">
                                        <p class="recruit_interviewSlider_head hp_noneSp">社内を支える部署です！</p>
                                        <div class="recruit_interviewSlider_nameWrap">
                                            <p class="recruit_interviewSlider_name">
                                                グループ総務部　経理
                                            </p>
                                            <p class="recruit_interviewSlider_name">
                                                K.T（入社5年目）
                                            </p>
                                        </div>
                                        <p class="recruit_interviewSlider_text">
                                            経理は営業部とは違い、お客様との接点はありません。<br>ですが会社内を支える縁の下の力持ちだと思っています。自分で仕事のやりかたを改善したり、<br>上司にも相談したりしながらスムーズに仕事が進められる働きやすい環境です。
                                        </p>
                                    </div>
                                </li>
                                <li class="recruit_interviewSlider_slide swiper-slide">
                                    <p class="recruit_interviewSlider_head __smaller hp_nonePc">会社が好きだから続けられます</p>
                                    <div class="recruit_interviewSlider_imgWrap">
                                        <img src="<?php echo_img('recruit_img_interview6.jpg') ?>" alt="N.Gさんの写真">
                                    </div>
                                    <div class="recruit_interviewSlider_textWrap">
                                        <p class="recruit_interviewSlider_head hp_noneSp">会社が好きだから続けられます</p>
                                        <div class="recruit_interviewSlider_nameWrap">
                                            <p class="recruit_interviewSlider_name">
                                                購買部
                                            </p>
                                            <p class="recruit_interviewSlider_name">
                                                N.G（入社23年目）
                                            </p>
                                        </div>
                                        <p class="recruit_interviewSlider_text">
                                            仕事ではスムーズに商品を届けることを心がけています。<br>上司や仲間と協力しながら仕事を進められるので、居心地が良いです。社長も社員の近くにいてくださいます。結婚、出産をし、2児の母となっても勤められる、ケアの整った会社です。
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="el_sliderBtn __prev js_prev">
                            <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="前へ">
                        </div>
                        <div class="el_sliderBtn __next js_next">
                            <img src="<?php echo_img('icon_circle_angle_right_color.svg') ?>" alt="次へ">
                        </div>
                        <div class="recruit_interviewSliderParent_pagination swiper-pagination js_pagination"></div>
                    </div>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <section class="ly_section __pB js_anchorLinkTarget" id="recruit-benefit">
                <div class="ly_container">
                    <div class="bl_head3 __noPcMb">
                        <span class="bl_head3_sub">福利厚生について</span>
                        <h2 class="bl_head3_text">社員の安心と<br class="hp_nonePc">快適な生活を支える<br>充実の福利厚生</h2>
                    </div>
                    <p class="recruit_benefitIntro">
                        緑川化成工業は、社員が安心して働き、充実した生活を送れるよう、幅広い福利厚生制度を整えています。ライフステージに合わせたサポートを通じて、仕事とプライベートの両立を応援します。
                    </p>
                    <ul class="bl_cardList">
                        <li class="bl_cardList_item">
                            <p class="bl_cardList_subHead __top">
                                ライフイベントサポート
                            </p>
                            <p class="bl_cardList_head">
                                産前産後休暇
                            </p>
                            <p class="bl_cardList_text">
                                出産前後の計98日間の休暇制度を設け、出産を控える社員を支援しています。
                            </p>
                        </li>
                        <li class="bl_cardList_item">
                            <p class="bl_cardList_subHead __top">
                                ライフイベントサポート
                            </p>
                            <p class="bl_cardList_head">
                                育児休暇
                            </p>
                            <p class="bl_cardList_text">
                                お子様が2歳の誕生日を迎える前日まで取得可能な育児休暇制度を整備し、育児と仕事の両立をサポートしています。
                            </p>
                        </li>
                        <li class="bl_cardList_item">
                            <p class="bl_cardList_subHead __top">
                                ライフイベントサポート
                            </p>
                            <p class="bl_cardList_head">
                                育児短縮勤務
                            </p>
                            <p class="bl_cardList_text">
                                お子様が小学校入学までの期間、短時間勤務が可能な制度を導入し、育児中の社員の働きやすさに配慮しています。
                            </p>
                        </li>
                        <li class="bl_cardList_item">
                            <p class="bl_cardList_subHead __top">
                                働き方サポート
                            </p>
                            <p class="bl_cardList_head">
                                完全週休二日制
                            </p>
                            <p class="bl_cardList_text">
                                土曜・日曜・祝日を休業日とする完全週休二日制を採用し、年間休日数は122日（当社カレンダーによる）を確保しています。
                            </p>
                        </li>
                        <li class="bl_cardList_item">
                            <p class="bl_cardList_subHead __top">
                                経済的サポート
                            </p>
                            <p class="bl_cardList_head">
                                各種手当
                            </p>
                            <p class="bl_cardList_text">
                                役職手当、家族手当（配偶者10,000円、子供1人につき13,000円、上限3人まで）、通勤手当（全額支給、非課税範囲）など、各種手当を支給しています。
                            </p>
                        </li>
                        <li class="bl_cardList_item">
                            <p class="bl_cardList_subHead __top">
                                基本的なサポート
                            </p>
                            <p class="bl_cardList_head">
                                社会保険完備
                            </p>
                            <p class="bl_cardList_text">
                                健康保険（介護保険含む）、厚生年金保険、雇用保険、労災保険など、各種社会保険に加入しています。
                            </p>
                        </li>
                    </ul>
                </div>
                <!-- /.ly_container -->
            </section>
            <!-- /.ly_section -->

            <div class="ly_section __gray js_anchorLinkTarget" id="recruit-entry">
                <div class="ly_container">
                    <p class="rectuir_mynavi">マイナビにて採用における<br class="hp_nonePc">詳細情報を掲載中です。</p>
                    <a href="https://job.mynavi.jp/26/pc/search/corp28937/outline.html" target="_blank" rel="noopener noreferrer" class="rectuir_mynaviImg">
                        <img src="<?php echo_img('recruit_img_mynavi.jpg') ?>" alt="マイナビ2026">
                    </a>
                </div>
                <!-- /.ly_container -->
            </div>
            <!-- /.ly_section -->
        </div>
        <!-- /.ly_flexInner -->
    </div>
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>