<?php

/************************************************
 * Contact Form 7 フォーム定義
 *************************************************/

$url_thanks = get_url(Page::CONTACT_THANKS);

$product_name_tag = '<input type="hidden" name="product-name" value="お問合せ">';
$product_name = '';

if (isset($_GET['product_name']) && $_GET['product_name'] !== '') {
    $product_name = htmlspecialchars($_GET['product_name'], ENT_QUOTES, 'UTF-8');
} elseif (isset($_GET['processed_production_name']) && $_GET['processed_production_name'] !== '') {
    $product_name = htmlspecialchars($_GET['processed_production_name'], ENT_QUOTES, 'UTF-8');
}

if (!empty($product_name)) {
    $product_name_tag = '
<div class="bl_form_inputWrap" data-input="product-name">
    <div class="bl_form_headWrap">
        <p class="bl_form_head">お問い合せ事項</p>
    </div>
    <div class="bl_form_inputInner">
        <p class=bl_form_data>' . $product_name . '</p>
    </div>
    <input type="hidden" name="product-name" value="' . $product_name . '">
</div>
';
}

define('CONTACT_FORM_GENERAL', [
    'title' => 'お問い合わせ',
    'form' => '
<div class="bl_form">
    <p class="bl_form_sendValidateError js_validateAlert">エラーが発生しました。<br>入力内容を修正し、再度送信を行ってください。</p>
    ' .
        $product_name_tag .
        '
    <div class="bl_form_inputWrap" data-input="overview">
        <div class="bl_form_headWrap">
            <p class="bl_form_head bl_form_head__req">お問い合わせの種類</p>
        </div>
        <div class="bl_form_inputInner">
            [radio overview class:bl_form_radio default:1 use_label_element "製品について" "加工/施工について" "採用について" "その他"]
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="company" data-validate="maxLength" data-max="60" data-label="会社名・組織名">
        <div class="bl_form_headWrap">
            <label class="bl_form_head" for="txtCompany">会社名・組織名</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-company class:bl_form_input id:txtCompany placeholder "例 ) 緑川化成工業(株)  ※個人の方は「個人」と入力"]
            <span class="bl_form_validate" data-err="company"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="belong" data-validate="maxLength" data-max="60" data-label="部署・役職名">
        <div class="bl_form_headWrap">
            <label class="bl_form_head" for="txtBelong">部署・役職名</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-belong class:bl_form_input id:txtBelong placeholder "例 ) 営業部"]
            <span class="bl_form_validate" data-err="belong"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="name" data-validate="require maxLength" data-max="60" data-label="お名前">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="txtName">お名前</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-name class:bl_form_input id:txtName placeholder "例 ) 山田 太郎"]
            <span class="bl_form_validate" data-err="name"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="furigana" data-validate="require hiragana maxLength" data-max="60" data-label="ふりがな">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="txtFrigana">ふりがな</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-furigana class:bl_form_input id:txtFrigana placeholder "例 ) やまだ たろう"]
            <span class="bl_form_validate" data-err="furigana"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="email" data-validate="require email" data-label="メールアドレス">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="txtMail">メールアドレス</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-email class:bl_form_input id:txtMail placeholder "例 ) example@mail.co.jp"]
            <span class="bl_form_validate" data-err="email"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="tel" data-validate="tel" data-label="電話番号">
        <div class="bl_form_headWrap">
            <label class="bl_form_head" for="txtTell">電話番号</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-tel class:bl_form_input class:js_inputTel id:txtTell placeholder "例 ) 000-0000-0000"]
            <span class="bl_form_validate" data-err="tel"></span>
        </div>
    </div>
    <!--
    <div class="bl_form_inputWrap" data-input="file" data-validate="file" data-label="書類添付" data-maxSize="5">
        <div class="bl_form_headWrap">
            <label class="bl_form_head" for="txtTell">書類添付</label>
        </div>
        <div class="bl_form_inputInner">
            <div>
                <div class="bl_form_fileWrap">
                    <label class="bl_form_fileLabel" for="file">ファイルを選択</label>
                    <span class="bl_form_fileName js_formFileName">選択されていません</span>
                    <span class="bl_form_fileTrash js_formFileTrash"><img src="' . get_img('icon_trash.svg') . '"></span>
                </div>
                [file upfile id:file class:bl_form_file class:js_formFileInput filetypes:pdf|png|jpeg|jpg|xlsx|xls|docx|doc limit:5mb]
                <p class="bl_form_fileExplain">添付可能ファイル：PDF、jpg、png、Excel、Word</p>
            </div>
            <span class="bl_form_validate" data-err="file"></span>
        </div>
    </div>
    -->
    <div class="bl_form_inputWrap" data-input="method">
        <div class="bl_form_headWrap">
            <p class="bl_form_head bl_form_head__req">ご希望のご連絡方法</p>
        </div>
        <div class="bl_form_inputInner">
            [radio your-method class:bl_form_radio class:bl_form_radio__pcFlex class:js_methodRadio default:1 use_label_element "メール" "電話"]
        </div>
    </div>
    <div class="bl_form_inputWrap __start" data-input="area" data-validate="require maxLength" data-max="1000" data-label="内容の詳細">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="areaContent">内容の詳細</label>
        </div>
        <div class="bl_form_inputInner">
            [textarea your-message class:bl_form_input class:bl_form_input__area id:areaContent placeholder "お問合せの詳細をご記入ください。"]
            <span class="bl_form_validate" data-err="area"></span>
        </div>
    </div>

    <div class="bl_form_policyWrap">
        <p class="bl_form_policy">
            <span>プライバシーポリシー</span>
            緑川化成工業株式会社（以下「当社」といいます。）は、本ウェブサイト上で提供するサービス（以下、「本サービス」といいます。）における、お客様の個人情報の取扱いについて、以下のとおりプライバシーポリシー（以下、「本ポリシー」といいます。）を定めます。<br>
            <br>
            1.取得する情報およびその取得方法<br>
            <br>
            弊社は、弊社が運営提供するサービス（以下「弊社サービス」といいます。）を通して、お客様の個人情報（個人情報保護法第２条第１項に定義される個人情報を意味します。以下同じ。）を適正な手段により取得いたします。なお、お客様は、本ポリシーに従った個人情報の取得及び取扱いに同意できない場合、弊社サービスを利用することはできません。弊社サービスを利用したお客様は、本ポリシーに同意したものとみなします。<br>
            <br>
            <br>
            2.個人情報の利用目的<br>
            <br>
            弊社がお客様の個人情報を収集・利用する目的は、以下のとおりです。<br>
            <br>
            （1）弊社サービスの提供・運営のため<br>
            （2）お客様からのお問い合わせに回答するため（本人確認を行うことを含む）<br>
            （3）お客様が利用中のサービスの新機能、更新情報、懸賞、キャンペーン等及び弊社が提供する他のサービスの案内のメールを送付するため<br>
            （4）メンテナンス、重要なお知らせなど必要に応じたご連絡のため<br>
            （5）利用規約に違反したお客様や、不正・不当な目的でサービスを利用しようとするお客様の特定をし、ご利用をお断りするため<br>
            （6）お客様にご自身の登録情報の閲覧や変更、削除、ご利用状況の閲覧を行っていただくため<br>
            （7）統計データ等、個人を特定できないデータを作成するため<br>
            （8）当社の新しいサービス、商品等を研究・開発するため<br>
            （9）有料サービスにおいて、お客様に利用料金を請求するため<br>
            （10）上記の利用目的に付随する目的<br>
            <br>
            <br>
            3.適切な安全管理措置の実施<br>
            <br>
            1.組織的安全管理措置<br>
            弊社は、組織的安全管理措置として、次に掲げる措置を講じます。<br>
            (1)組織体制の整備<br>
            安全管理措置を講ずるための組織体制を整備致します。<br>
            (2)情報の取扱いに係る規律に従った運用<br>
            あらかじめ整備された情報の取扱いに係る規律に従って情報を取り扱います。<br>
            なお、整備された情報の取扱いに係る規律に従った運用の状況を確認するため、利用状況等を記録致します。<br>
            (3)情報の取扱状況を確認する手段の整備<br>
            情報の取扱状況を確認するための手段を整備致します。<br>
            (4)漏えい等事案に対応する体制の整備<br>
            漏えい等事案の発生又は兆候を把握した場合に適切かつ迅速に対応するための体制を整備致します。<br>
            (5)取扱状況の把握及び安全管理措置の見直し<br>
            情報の取扱状況を把握し、安全管理措置の評価、見直し及び改善に取り組みます。<br>
            <br>
            2.人的安全管理措置<br>
            弊社は、人的安全管理措置として、従業者に、情報の適正な取扱いを周知徹底するとともに適切な教育を行います。また、弊社は、従業者に情報を取り扱わせるに当たっては、個人情報保護法第24条その他法令に基づき従業者に対する監督を致します。<br>
            <br>
            3.物理的安全管理措置<br>
            弊社は、物理的安全管理措置として、次に掲げる措置を講じます。<br>
            （1）情報を取り扱う区域の管理<br>
            情報データベース等を取り扱うサーバやメインコンピュータ等の重要な情報システムを管理する区域及びその他の情報を取り扱う事務を実施する区域について、それぞれ適切な管理を行います。<br>
            （2）機器及び電子媒体等の盗難等の防止<br>
            情報を取り扱う機器、電子媒体及び書類等の盗難又は紛失等を防止するために、適切な管理を行います。<br>
            （3）電子媒体等を持ち運ぶ場合の漏えい等の防止<br>
            情報が記録された電子媒体又は書類等を持ち運ぶ場合、容易に情報が判明しないよう、安全な方策を講じます。<br>
            （4）情報の削除及び機器、電子媒体等の廃棄<br>
            情報を削除し又は情報が記録された機器、電子媒体等を廃棄する場合は、復元不可能な手段で行います。<br>
            <br>
            4.技術的安全管理措置<br>
            弊社は、情報システム（パソコン等の機器を含む。）を使用して情報を取り扱う場合（インターネット等を通じて外部と送受信等する場合を含む。）、技術的安全管理措置として、次に掲げる措置を講じます。<br>
            （1）アクセス制御<br>
            担当者及び取り扱う情報データベース等の範囲を限定するために、適切なアクセス制御を行います。<br>
            （2）アクセス者の識別と認証<br>
            情報を取り扱う情報システムを使用する従業者が正当なアクセス権を有する者であることを、識別した結果に基づき認証致します。<br>
            （3）外部からの不正アクセス等の防止<br>
            情報を取り扱う情報システムを外部からの不正アクセス又は不正ソフトウェアから保護する仕組みを導入し、適切に運用致します。<br>
            （4）情報システムの使用に伴う漏えい等の防止<br>
            情報システムの使用に伴う情報の漏えい等を防止するための措置を講じ、適切に運用致します。<br>
            <br>
            5.外的環境の把握<br>
            弊社が、外国において情報を取り扱う場合、当該外国の個人情報の保護に関する制度等を把握した上で、情報の安全管理のために必要かつ適切な措置を講じます。<br>
            <br>
            <br>
            4.個人情報の第三者提供<br>
            <br>
            弊社は、個人情報保護法その他法令に掲げる場合を除いて、あらかじめお客様の同意を得ることなく、第三者に個人情報を提供することはありません。<br>
            <br>
            <br>
            5.個人情報の開示、訂正、利用停止等の申請への応対<br>
            <br>
            お客様より、個人情報の利用目的の通知、開示、訂正・追加・削除・利用停止・消去等（以下「開示等」という。）の請求があった場合、ご本人確認をした上で、当該お客様に対し個人情報保護法の定めに従い、応対いたしますので、かかる請求を行う場合、第８項の窓口にご連絡下さい。但し、個人情報保護法その他の法令により弊社が開示等の義務を負わない場合は、この限りではありません。なお、当該請求に際し発生した通信費、交通費、及びご本人確認の際にご用意いただく資料等に関する費用につきましては、全てお客様のご負担とさせていただきます。<br>
            <br>
            <br>
            6.本ポリシーの変更<br>
            <br>
            弊社は、お客様のご意見や弊社内の合理的な判断をもとに、本ポリシーの内容について変更する場合があります。<br>
            <br>
            <br>
            7.免責事項<br>
            <br>
            弊社ウェブサイトに掲載されている情報の正確性には万全を期していますが、利用者が弊社ウェブサイトの情報を用いて行う一切の行為に関して、一切の責任を負わないものとします。<br>
            弊社は、利用者が弊社ウェブサイトを利用したことにより生じた利用者の損害及び利用者が第三者に与えた損害に関して、一切の責任を負わないものとします。
        </p>
    </div>

    <div class="bl_form_check">
        <label class="bl_form_checkLabel js_formCheckLabel" for="cbPolicy"></label>
        <p class="bl_form_checkLink" id="policyCheckLabel">プライバシーポリシーに同意する</p>
        <span class="bl_form_validate" data-err="policy"></span>
    </div>
    <div data-input="policy" data-validate="requireCheck" data-label="">
        [checkbox agree class:bl_form_checkBox class:js_agreeCheck ""]
    </div>

    <div class="bl_form_btn bl_form_btn__submit">
        [submit class:el_formButton class:js_submit "送信"]
    </div>
    <div class="bl_form_btn js_confirmBtn">
        <button type="button" class="el_btn __type2">内容を確認する</button>
    </div>
</div>

<script>
// CF7完了画面遷移
document.addEventListener("wpcf7mailsent", function (event) {
    location = "' . $url_thanks . '";
}, false);
</script>
'
]);

define('CONTACT_FORM_DOWNLOAD', [
    'title' => 'ダウンロードフォーム',
    'form' => '
<div class="bl_form __download">
    <p class="bl_form_sendValidateError js_validateAlert">エラーが発生しました。<br>入力内容を修正し、再度送信を行ってください。</p>
    <div class="bl_form_inputWrap" data-input="product-name">
        <div class="bl_form_headWrap">
            <p class="bl_form_head">製品名</p>
        </div>
        <div class="bl_form_inputInner">
            <p class=bl_form_data>' . $product_name . '</p>
        </div>
        <input type="hidden" name="product-name" value="' . $product_name . '">
    </div>
    <div class="bl_form_inputWrap" data-input="name" data-validate="require maxLength" data-max="60" data-label="お名前">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="txtName">お名前</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-name class:bl_form_input id:txtName placeholder "例 ) 山田 太郎"]
            <span class="bl_form_validate" data-err="name"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="furigana" data-validate="hiragana maxLength" data-max="60" data-label="ふりがな">
        <div class="bl_form_headWrap">
            <label class="bl_form_head" for="txtFrigana">ふりがな</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-furigana class:bl_form_input id:txtFrigana placeholder "例 ) やまだ たろう"]
            <span class="bl_form_validate" data-err="furigana"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="company" data-validate="maxLength" data-max="60" data-label="貴社・組織名">
        <div class="bl_form_headWrap">
            <label class="bl_form_head" for="txtCompany">貴社・組織名</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-company class:bl_form_input id:txtCompany placeholder "例 ) 緑川化成工業株式会社"]
            <span class="bl_form_validate" data-err="company"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="location" data-validate="require" data-label="所在地（都道府県）">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req">所在地（都道府県）</label>
        </div>
        <div class="bl_form_inputInner">
            <div class="bl_form_selectWrap">
                [select location class:bl_form_select first_as_label "選択してください" "北海道" "青森県" "岩手県" "宮城県" "秋田県" "山形県" "福島県" "茨城県" "栃木県" "群馬県" "埼玉県" "千葉県" "東京都" "神奈川県" "新潟県" "富山県" "石川県" "福井県" "山梨県" "長野県" "岐阜県" "静岡県" "愛知県" "三重県" "滋賀県" "京都府" "大阪府" "兵庫県" "奈良県" "和歌山県" "鳥取県" "島根県" "岡山県" "広島県" "山口県" "徳島県" "香川県" "愛媛県" "高知県" "福岡県" "佐賀県" "長崎県" "熊本県" "大分県" "宮崎県" "鹿児島県" "沖縄県"]
            </div>
            <span class="bl_form_validate" data-err="location"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="email" data-validate="require email" data-label="メールアドレス">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="txtMail">メールアドレス</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-email class:bl_form_input id:txtMail placeholder "例 ) example@mail.co.jp"]
            <span class="bl_form_validate" data-err="email"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="tel" data-validate="require tel" data-label="電話番号">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="txtTell">電話番号</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-tel class:bl_form_input id:txtTell placeholder "例 ) 000-0000-0000"]
            <span class="bl_form_validate" data-err="tel"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap" data-input="fax" data-validate="tel" data-label="FAX番号">
        <div class="bl_form_headWrap">
            <label class="bl_form_head" for="txtFax">FAX番号</label>
        </div>
        <div class="bl_form_inputInner">
            [text your-fax class:bl_form_input id:txtFax placeholder "例 ) 000-0000-0000"]
            <span class="bl_form_validate" data-err="fax"></span>
        </div>
    </div>
    <div class="bl_form_inputWrap __start" data-input="area" data-validate="require maxLength" data-max="1000" data-label="用途をご記入ください">
        <div class="bl_form_headWrap">
            <label class="bl_form_head bl_form_head__req" for="areaContent">用途をご記入ください</label>
        </div>
        <div class="bl_form_inputInner">
            [textarea your-message class:bl_form_input class:bl_form_input__area class:bl_form_input__box id:areaContent]
            <span class="bl_form_validate" data-err="area"></span>
        </div>
    </div>

    <div class="bl_form_policyWrap">
        <p class="bl_form_policy">
            <span>プライバシーポリシー</span>
            緑川化成工業株式会社（以下「当社」といいます。）は、本ウェブサイト上で提供するサービス（以下、「本サービス」といいます。）における、お客様の個人情報の取扱いについて、以下のとおりプライバシーポリシー（以下、「本ポリシー」といいます。）を定めます。<br>
            <br>
            1.取得する情報およびその取得方法<br>
            <br>
            弊社は、弊社が運営提供するサービス（以下「弊社サービス」といいます。）を通して、お客様の個人情報（個人情報保護法第２条第１項に定義される個人情報を意味します。以下同じ。）を適正な手段により取得いたします。なお、お客様は、本ポリシーに従った個人情報の取得及び取扱いに同意できない場合、弊社サービスを利用することはできません。弊社サービスを利用したお客様は、本ポリシーに同意したものとみなします。<br>
            <br>
            <br>
            2.個人情報の利用目的<br>
            <br>
            弊社がお客様の個人情報を収集・利用する目的は、以下のとおりです。<br>
            <br>
            （1）弊社サービスの提供・運営のため<br>
            （2）お客様からのお問い合わせに回答するため（本人確認を行うことを含む）<br>
            （3）お客様が利用中のサービスの新機能、更新情報、懸賞、キャンペーン等及び弊社が提供する他のサービスの案内のメールを送付するため<br>
            （4）メンテナンス、重要なお知らせなど必要に応じたご連絡のため<br>
            （5）利用規約に違反したお客様や、不正・不当な目的でサービスを利用しようとするお客様の特定をし、ご利用をお断りするため<br>
            （6）お客様にご自身の登録情報の閲覧や変更、削除、ご利用状況の閲覧を行っていただくため<br>
            （7）統計データ等、個人を特定できないデータを作成するため<br>
            （8）当社の新しいサービス、商品等を研究・開発するため<br>
            （9）有料サービスにおいて、お客様に利用料金を請求するため<br>
            （10）上記の利用目的に付随する目的<br>
            <br>
            <br>
            3.適切な安全管理措置の実施<br>
            <br>
            1.組織的安全管理措置<br>
            弊社は、組織的安全管理措置として、次に掲げる措置を講じます。<br>
            (1)組織体制の整備<br>
            安全管理措置を講ずるための組織体制を整備致します。<br>
            (2)情報の取扱いに係る規律に従った運用<br>
            あらかじめ整備された情報の取扱いに係る規律に従って情報を取り扱います。<br>
            なお、整備された情報の取扱いに係る規律に従った運用の状況を確認するため、利用状況等を記録致します。<br>
            (3)情報の取扱状況を確認する手段の整備<br>
            情報の取扱状況を確認するための手段を整備致します。<br>
            (4)漏えい等事案に対応する体制の整備<br>
            漏えい等事案の発生又は兆候を把握した場合に適切かつ迅速に対応するための体制を整備致します。<br>
            (5)取扱状況の把握及び安全管理措置の見直し<br>
            情報の取扱状況を把握し、安全管理措置の評価、見直し及び改善に取り組みます。<br>
            <br>
            2.人的安全管理措置<br>
            弊社は、人的安全管理措置として、従業者に、情報の適正な取扱いを周知徹底するとともに適切な教育を行います。また、弊社は、従業者に情報を取り扱わせるに当たっては、個人情報保護法第24条その他法令に基づき従業者に対する監督を致します。<br>
            <br>
            3.物理的安全管理措置<br>
            弊社は、物理的安全管理措置として、次に掲げる措置を講じます。<br>
            （1）情報を取り扱う区域の管理<br>
            情報データベース等を取り扱うサーバやメインコンピュータ等の重要な情報システムを管理する区域及びその他の情報を取り扱う事務を実施する区域について、それぞれ適切な管理を行います。<br>
            （2）機器及び電子媒体等の盗難等の防止<br>
            情報を取り扱う機器、電子媒体及び書類等の盗難又は紛失等を防止するために、適切な管理を行います。<br>
            （3）電子媒体等を持ち運ぶ場合の漏えい等の防止<br>
            情報が記録された電子媒体又は書類等を持ち運ぶ場合、容易に情報が判明しないよう、安全な方策を講じます。<br>
            （4）情報の削除及び機器、電子媒体等の廃棄<br>
            情報を削除し又は情報が記録された機器、電子媒体等を廃棄する場合は、復元不可能な手段で行います。<br>
            <br>
            4.技術的安全管理措置<br>
            弊社は、情報システム（パソコン等の機器を含む。）を使用して情報を取り扱う場合（インターネット等を通じて外部と送受信等する場合を含む。）、技術的安全管理措置として、次に掲げる措置を講じます。<br>
            （1）アクセス制御<br>
            担当者及び取り扱う情報データベース等の範囲を限定するために、適切なアクセス制御を行います。<br>
            （2）アクセス者の識別と認証<br>
            情報を取り扱う情報システムを使用する従業者が正当なアクセス権を有する者であることを、識別した結果に基づき認証致します。<br>
            （3）外部からの不正アクセス等の防止<br>
            情報を取り扱う情報システムを外部からの不正アクセス又は不正ソフトウェアから保護する仕組みを導入し、適切に運用致します。<br>
            （4）情報システムの使用に伴う漏えい等の防止<br>
            情報システムの使用に伴う情報の漏えい等を防止するための措置を講じ、適切に運用致します。<br>
            <br>
            5.外的環境の把握<br>
            弊社が、外国において情報を取り扱う場合、当該外国の個人情報の保護に関する制度等を把握した上で、情報の安全管理のために必要かつ適切な措置を講じます。<br>
            <br>
            <br>
            4.個人情報の第三者提供<br>
            <br>
            弊社は、個人情報保護法その他法令に掲げる場合を除いて、あらかじめお客様の同意を得ることなく、第三者に個人情報を提供することはありません。<br>
            <br>
            <br>
            5.個人情報の開示、訂正、利用停止等の申請への応対<br>
            <br>
            お客様より、個人情報の利用目的の通知、開示、訂正・追加・削除・利用停止・消去等（以下「開示等」という。）の請求があった場合、ご本人確認をした上で、当該お客様に対し個人情報保護法の定めに従い、応対いたしますので、かかる請求を行う場合、第８項の窓口にご連絡下さい。但し、個人情報保護法その他の法令により弊社が開示等の義務を負わない場合は、この限りではありません。なお、当該請求に際し発生した通信費、交通費、及びご本人確認の際にご用意いただく資料等に関する費用につきましては、全てお客様のご負担とさせていただきます。<br>
            <br>
            <br>
            6.本ポリシーの変更<br>
            <br>
            弊社は、お客様のご意見や弊社内の合理的な判断をもとに、本ポリシーの内容について変更する場合があります。<br>
            <br>
            <br>
            7.免責事項<br>
            <br>
            弊社ウェブサイトに掲載されている情報の正確性には万全を期していますが、利用者が弊社ウェブサイトの情報を用いて行う一切の行為に関して、一切の責任を負わないものとします。<br>
            弊社は、利用者が弊社ウェブサイトを利用したことにより生じた利用者の損害及び利用者が第三者に与えた損害に関して、一切の責任を負わないものとします。
        </p>
    </div>

    <div class="bl_form_check">
        <label class="bl_form_checkLabel js_formCheckLabel" for="cbPolicy"></label>
        <p class="bl_form_checkLink" id="policyCheckLabel">プライバシーポリシーに同意する</p>
        <span class="bl_form_validate" data-err="policy"></span>
    </div>
    <div data-input="policy" data-validate="requireCheck" data-label="">
        [checkbox agree class:bl_form_checkBox class:js_agreeCheck ""]
    </div>

    <div class="bl_form_btn bl_form_btn__submit">
        [submit class:el_formButton class:js_submit "送信"]
    </div>
    <div class="bl_form_btn js_confirmBtn">
        <button type="button" class="el_btn __type2">内容を確認する</button>
    </div>
</div>

<script>
// CF7完了画面遷移
document.addEventListener("wpcf7mailsent", function (event) {
    location = "' . $url_thanks . '";
}, false);
</script>
'
]);

// Contact Form 7 フォーム設定配列
const CONTACT_FORMS = [
    CONTACT_FORM_GENERAL,
    CONTACT_FORM_DOWNLOAD
];
