<div class="ly_container" id="formInput">
    <div class="bl_head3">
        <span class="bl_head3_sub">お問い合わせ</span>
        <h2 class="bl_head3_text">お問い合わせ内容確認</h2>
    </div>
    <p class="contact_intro">入力内容をご確認いただき、「送信する」ボタンを押下してください。</p>
    <!-- /.bl_subHead2 -->
    <p class="bl_contact_annotation">
        <span class="contact_annotation__point">*</span> は入力必須項目です。
    </p>
    <div class="bl_contact_formWrap">
        <div class="bl_form __confirm">
            <?php if(isset($_GET['product_name']) && $_GET['product_name'] !== ''): ?>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <p class="bl_form_head">お問合せ事項</p>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="product-name"></p>
                </div>
            </div>
            <?php endif; ?>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <p class="bl_form_head">お問合せ内容</p>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="overview"></p>
                </div>
            </div>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head">会社名</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="company"></p>
                </div>
            </div>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head">部署・役職名</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="belong"></p>
                </div>
            </div>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head bl_form_head__req">お名前</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="name"></p>
                </div>
            </div>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head bl_form_head__req">ふりがな</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="furigana"></p>
                </div>
            </div>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head bl_form_head__req">メールアドレス</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="email"></p>
                </div>
            </div>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head">電話番号</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="tel"></p>
                </div>
            </div>
            <!-- <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head">書類添付</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="file"></p>
                </div>
            </div> -->
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <p class="bl_form_head bl_form_head__req">ご希望のご連絡方法</p>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="method"></p>
                </div>
            </div>
            <div class="bl_form_inputWrap">
                <div class="bl_form_headWrap">
                    <label class="bl_form_head bl_form_head__req">内容の詳細</label>
                </div>
                <div class="bl_form_inputInner">
                    <p class="bl_form_confirm" data-confirm="area"></p>
                </div>
            </div>
            <div class="bl_form_check bl_form_check__checked">
                <label class="bl_form_checkLabel js_formCheckLabel"></label>
                <p class="bl_form_checkLink">プライバシーポリシーに同意する</p>
            </div>

            <div class="bl_form_confirmBtn">
                <button class="el_btn __type2 __noIcon js_confirmBackBtn" type="button">
                    戻る
                </button>
                <button class="el_btn __type2 __noIcon el_formButton js_submitBtn js_loading" type="button">
                    送信する
                </button>
            </div>
        </div>
    </div>
</div>