<?php
/**
 * ページ固有アセット読み込み
 *
 * このファイルでは、ページIDを元にページ固有のCSS/JSと共通CSSを読み込みます。
 */

// 設定値（パス・ファイル名）
$page              = $pageId ?? '';
$distBaseUrl       = '/dist/';
$cssUrlPath        = "{$distBaseUrl}css/";
$jsUrlPath         = "{$distBaseUrl}js/";
$jsFileDir         = __DIR__ . '/../../dist/js/';
$commonCssFileName = 'common.css';
$commonJsFileName  = 'commonPage.js';
?>
<?php if (!empty($pageId)): ?>
    <?php $cssPagePath = "{$cssUrlPath}{$pageId}.css"; ?>

    <!-- css page -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars(
        $cssPagePath,
        ENT_QUOTES,
        'UTF-8',
    ); ?>">
    <!-- css common -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars(
        "{$cssUrlPath}{$commonCssFileName}",
        ENT_QUOTES,
        'UTF-8',
    ); ?>">

    <!-- js (ページ固有 -> 無ければ共通) -->
    <?php
    $pageJsPath   = "{$jsUrlPath}{$pageId}.js";
    $commonJsPath = "{$jsUrlPath}{$commonJsFileName}";
    $existPage    = file_exists($jsFileDir . $pageId . '.js');
    $finalJsPath  = $existPage ? $pageJsPath : $commonJsPath;
    ?>
    <script src="<?php echo htmlspecialchars($finalJsPath, ENT_QUOTES, 'UTF-8'); ?>"></script>
<?php endif; ?>

<?php //Swiper

if ($page === Page::PAGE_SAMPLE || $page === Page::PAGE_SAMPLE_ABOUT): ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<?php endif; ?>

<?php //ScrollHint

if ($page === Page::PAGE_SAMPLE || $page === Page::PAGE_SAMPLE_ABOUT): ?>
    <link rel="stylesheet" href="https://unpkg.com/scroll-hint@latest/css/scroll-hint.css">
    <script src="https://unpkg.com/scroll-hint@latest/js/scroll-hint.min.js"></script>
<?php endif; ?>

