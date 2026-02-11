<?php
/**
 * サンプルサイト - Worksページ
 *
 * 制作実績のページです。
 * ob_start/ob_get_cleanを使用してページコンテンツを取得し、レイアウトに差し込みます。
 */

// 共通ファイルの読み込み
require_once __DIR__ . '/includes/init.php';

// ページID
$pageId = PAGE_ID::SAMPLE_WORKS;

// ページコンテンツを取得
ob_start();
?>

<section id="works" class="ly_section __normal">
    <div class="ly_container __medium">
        <?php include __DIR__ . '/includes/modules/breadcrumbs.php'; ?>

        <div class="un_pageHeader">
            <h1 class="un_pageHeader_title">Works</h1>
            <p class="un_pageHeader_description">制作実績</p>
        </div>

        <div class="un_worksGrid">
            <?php
            // サンプルデータ
            $works = [
                [
                    'title' => 'プロジェクト1',
                    'description' => 'サンプルプロジェクトの説明です。',
                    'image' => 'work1.png'
                ],
                [
                    'title' => 'プロジェクト2',
                    'description' => 'サンプルプロジェクトの説明です。',
                    'image' => 'work2.png'
                ],
                [
                    'title' => 'プロジェクト3',
                    'description' => 'サンプルプロジェクトの説明です。',
                    'image' => 'work3.png'
                ],
                [
                    'title' => 'プロジェクト4',
                    'description' => 'サンプルプロジェクトの説明です。',
                    'image' => 'work4.png'
                ],
            ];

            foreach ($works as $work):
            ?>
            <article class="bl_card">
                <div class="bl_card_image">
                    <picture>
                        <?php
                        render_img([
                            'src' => $work['image'],
                            'alt' => $work['title'],
                            'width' => '600',
                            'height' => '400',
                            'class' => 'bl_card_img'
                        ]);
                        ?>
                    </picture>
                </div>
                <div class="bl_card_header">
                    <h3 class="bl_card_title"><?php echo htmlspecialchars($work['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                </div>
                <div class="bl_card_body">
                    <p class="bl_card_text"><?php echo htmlspecialchars($work['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="bl_card_footer">
                    <a href="#" class="el_btn el_btn__outline">詳細を見る</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
$pageContents = ob_get_clean();

// ベースレイアウトを読み込み（init.phpとhead.phpも読み込まれる）
// CSS/JSファイルはbase.phpでページIDから自動的に読み込まれます
include __DIR__ . '/includes/layouts/base.php';
?>

