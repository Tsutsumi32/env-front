<?php

/**
 * サンプルサイト - トップページ
 *
 * サンプルサイトのトップページです。
 * ob_start/ob_get_cleanを使用してページコンテンツを取得し、レイアウトに差し込みます。
 */

// 共通ファイルの読み込み
require_once __DIR__ . '/includes/init.php';

// ページコンテンツを取得
ob_start();
?>

<section id="top" data-scope="home">
    <div class="ly_container __medium">
        <?php include __DIR__ . '/includes/modules/breadcrumbs.php'; ?>

        <div class="un_hero">
            <h1 class="un_hero_title">Welcome to Sample Site</h1>
            <p class="un_hero_description">サンプルサイトへようこそ<br></p>
            <div class="un_hero_actions">
                <a href="/about.php" class="el_btn el_btn__primary">Aboutを見る</a>
                <button type="button" class="el_btn el_btn__outline" data-action="modal.open" data-modal-id="sample">モーダルを開く</button>
                <button type="button" class="el_btn el_btn__outline" data-action="sampleClick">サンプルボタン</button>
            </div>
        </div>

        <div class="ly_section __small _top">
            <div class="ly_container __medium">
                <p class="un_media">
                    メディアクエリテスト
                </p>
            </div>
        </div>

        <div class="un_feature">
            <h2 class="un_feature_title">Feature</h2>
            <div class="un_feature_list">
                <div class="un_feature_item">
                    <div class="un_feature_icon">✨</div>
                    <h3 class="un_feature_itemTitle">Feature 1</h3>
                    <p class="un_feature_itemText">サンプル機能の説明です。ここに詳しい説明が入ります。</p>
                    <a href="/works.php" class="el_btn el_btn__outline el_btn__small">詳細を見る</a>
                </div>
                <div class="un_feature_item">
                    <div class="un_feature_icon">🚀</div>
                    <h3 class="un_feature_itemTitle">Feature 2</h3>
                    <p class="un_feature_itemText">サンプル機能の説明です。ここに詳しい説明が入ります。</p>
                    <a href="/works.php" class="el_btn el_btn__outline el_btn__small">詳細を見る</a>
                </div>
                <div class="un_feature_item">
                    <div class="un_feature_icon">💡</div>
                    <h3 class="un_feature_itemTitle">Feature 3</h3>
                    <p class="un_feature_itemText">サンプル機能の説明です。ここに詳しい説明が入ります。</p>
                    <a href="/works.php" class="el_btn el_btn__outline el_btn__small">詳細を見る</a>
                </div>
            </div>
        </div>

        <div class="bl_accordionSection">
            <h2 class="bl_accordionSection_title">FAQ</h2>
            <div class="bl_accordionSection_list">
                <div class="bl_accordion has_accordion" data-module="accordion">
                    <button type="button" class="bl_accordion_btn" data-accordion-trigger>
                        <span class="bl_accordion_btnText">よくある質問1</span>
                        <span class="bl_accordion_btnIcon">+</span>
                    </button>
                    <div class="bl_accordion_contents" data-accordion-contents>
                        <div class="bl_accordion_inner">
                            <p class="bl_accordion_text">回答内容がここに入ります。回答内容がここに入ります。回答内容がここに入ります。</p>
                        </div>
                    </div>
                </div>
                <div class="bl_accordion has_accordion" data-module="accordion">
                    <button type="button" class="bl_accordion_btn" data-accordion-trigger>
                        <span class="bl_accordion_btnText">よくある質問2</span>
                        <span class="bl_accordion_btnIcon">+</span>
                    </button>
                    <div class="bl_accordion_contents" data-accordion-contents>
                        <div class="bl_accordion_inner">
                            <p class="bl_accordion_text">回答内容がここに入ります。回答内容がここに入ります。回答内容がここに入ります。</p>
                        </div>
                    </div>
                </div>
                <div class="bl_accordion has_accordion" data-module="accordion">
                    <button type="button" class="bl_accordion_btn" data-accordion-trigger>
                        <span class="bl_accordion_btnText">よくある質問3</span>
                        <span class="bl_accordion_btnIcon">+</span>
                    </button>
                    <div class="bl_accordion_contents" data-accordion-contents>
                        <div class="bl_accordion_inner">
                            <p class="bl_accordion_text">回答内容がここに入ります。回答内容がここに入ります。回答内容がここに入ります。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// 共通モーダル（data-action="modal.open/close" で開閉。data-modal-id で複数識別可能）
?>
<div class="bl_modal has_modal" data-module="modal" data-modal-id="sample" hidden aria-hidden="true">
    <div class="bl_modal_overlay" data-modal-overlay aria-hidden="true"></div>
    <div class="bl_modal_dialog" data-modal-dialog role="dialog" aria-modal="true">
        <div class="bl_modal_content" data-modal-content data-modal-scroll>
            <p>サンプルモーダルです。</p>
        </div>
        <button type="button" data-action="modal.close">閉じる</button>
    </div>
</div>

<?php
$pageContents = ob_get_clean();

// ベースレイアウトを読み込み（init.phpとhead.phpも読み込まれる）
// CSS/JSファイルはbase.phpでページIDから自動的に読み込まれます
include __DIR__ . '/includes/layouts/base.php';
?>
