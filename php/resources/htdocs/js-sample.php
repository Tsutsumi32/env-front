<?php
/**
 * サンプルサイト - Aboutページ
 *
 * このサイトについてのページです。
 * ob_start/ob_get_cleanを使用してページコンテンツを取得し、レイアウトに差し込みます。
 */

// 共通ファイルの読み込み
require_once __DIR__ . '/includes/init.php';

// ページコンテンツを取得
ob_start();
?>

<section id="about" class="ly_section __normal">
    <div class="ly_container __medium">
        <?php include __DIR__ . '/includes/modules/breadcrumbs.php'; ?>

        <div class="un_pageHeader">
            <h1 class="un_pageHeader_title">About</h1>
            <p class="un_pageHeader_description">このサイトについて</p>
        </div>

        <div class="un_aboutContent">
            <div class="un_aboutContent_section">
                <h2 class="un_aboutContent_title">私たちについて</h2>
                <p class="un_aboutContent_text">
                    このサイトは、サンプルサイトのデモンストレーションとして作成されました。
                    モダンなWeb技術を使用して、レスポンシブでアクセシブルなデザインを実現しています。
                </p>
            </div>

            <div class="un_aboutContent_section">
                <h2 class="un_aboutContent_title">技術スタック</h2>
                <div class="un_aboutContent_techGrid">
                    <?php
                    $techStack = [
                        [
                            'title' => 'PHP',
                            'text' => 'サーバーサイドのロジックを実装しています。',
                        ],
                        [
                            'title' => 'SCSS',
                            'text' => 'メンテナンスしやすいスタイルシートを記述しています。',
                        ],
                        [
                            'title' => 'JavaScript (ES6+)',
                            'text' => 'モダンなJavaScriptでインタラクティブな機能を実装しています。',
                        ],
                        [
                            'title' => 'HTML5',
                            'text' => 'セマンティックなマークアップで構造化しています。',
                        ],
                    ];

                    foreach ($techStack as $tech):
                    ?>
                    <div class="bl_card">
                        <div class="bl_card_header">
                            <h3 class="bl_card_title"><?php echo htmlspecialchars($tech['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        </div>
                        <div class="bl_card_body">
                            <p class="bl_card_text"><?php echo htmlspecialchars($tech['text'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="un_aboutContent_section">
                <a href="/works.php" class="el_btn el_btn__primary el_btn__large">制作実績を見る</a>
            </div>
        </div>
    </div>
</section>

<?php
$pageContents = ob_get_clean();

// ベースレイアウトを読み込み（init.phpとhead.phpも読み込まれる）
// CSS/JSファイルはbase.phpでページIDから自動的に読み込まれます
include __DIR__ . '/includes/layouts/base.php';
?>

