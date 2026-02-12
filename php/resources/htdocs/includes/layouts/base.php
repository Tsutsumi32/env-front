<?php
/**
 * ベースレイアウトファイル
 *
 * このファイルでは、全ページ共通のレイアウト構造を定義します。
 * headタグ、header、メインコンテンツ、footerを含む基本構造を提供します。
 * ページIDに基づいて、自動的に該当するCSS/JSファイルを読み込みます。
 * ※呼び出し元（各ページ）で init.php を読み込み、$pageId が設定されている前提です。
 *
 * @param string $pageContents ページコンテンツ（ob_start/ob_get_cleanで取得した内容）
 */

// ページコンテンツが指定されていない場合は空文字列
$pageContents = $pageContents ?? '';
?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">

    <?php include __DIR__ . '/../head/title.php'; ?>
    <?php include __DIR__ . '/../head/description.php'; ?>
    <?php include __DIR__ . '/../head/noindex.php'; ?>
    <?php include __DIR__ . '/../head/ogp.php'; ?>
    <?php include __DIR__ . '/../head/favicon.php'; ?>
    <?php include __DIR__ . '/../head/theme-color.php'; ?>
    <?php include __DIR__ . '/../head/font.php'; ?>

    <?php
    // ページID（画面キー）をそのままファイル名としてCSS/JSを自動読み込み
    // 共通スタイル（global, helpers, header, footer, layouts）は各ページのCSSファイルに含まれます
    $distPath = "/dist/";
    $cssPath = "{$distPath}css/";
    $jsPath = "{$distPath}js/";
    if (!empty($pageId)) {
        $cssPagePath = "{$cssPath}{$pageId}.css";
        $jsPagePath = "{$jsPath}{$pageId}.js";
    ?>
    <!-- css page -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars($cssPagePath, ENT_QUOTES, 'UTF-8'); ?>">
    <!-- css common -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars("{$cssPath}common.css", ENT_QUOTES, 'UTF-8'); ?>">
    <!-- js -->
    <script type="module" src="<?php echo htmlspecialchars($jsPagePath, ENT_QUOTES, 'UTF-8'); ?>" defer></script>
    <?php
    }
    ?>
</head>

<?php
    // data-page属性の設定
?>
<body class="is_nojs"<?php echo !empty($pageId) ? ' data-page="' . htmlspecialchars($pageId, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
    <?php include __DIR__ . '/header.php'; ?>

    <main class="ly_main">
        <?php echo $pageContents; ?>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>

