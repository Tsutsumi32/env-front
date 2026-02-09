<?php
/**
 * パンくずリストコンポーネント
 *
 * このファイルは、パンくずリストを表示するためのコンポーネントです。
 * $pageId変数が定義されている前提で、PageConfigから取得したパンくずデータを基に、HTMLを出力します。
 */

// PageConfigクラスが読み込まれていない場合はinit.phpを読み込む
if (!class_exists('PageConfig')) {
    require_once __DIR__ . '/../init.php';
}

// パンくずリストを取得
$breadcrumbs = PageConfig::getBreadcrumbs($pageId ?? '');

// パンくずリストが空の場合は何も出力しない
if (!empty($breadcrumbs)):
?>
<nav class="bl_breadcrumbs" aria-label="パンくずリスト">
    <ol class="bl_breadcrumbs_list">
        <?php
        $count = count($breadcrumbs);
        foreach ($breadcrumbs as $index => $item):
            $isLast = ($index === $count - 1);
        ?>
            <li class="bl_breadcrumbs_item">
                <?php if ($isLast): ?>
                    <span class="bl_breadcrumbs_text" aria-current="page"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php else: ?>
                    <a href="<?php echo htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8'); ?>" class="bl_breadcrumbs_link"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                <?php endif; ?>
            </li>
            <?php if (!$isLast): ?>
                <li class="bl_breadcrumbs_separator" aria-hidden="true">></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>

