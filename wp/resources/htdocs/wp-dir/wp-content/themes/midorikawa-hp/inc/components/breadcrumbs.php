<?php
/************************************************
 * パンくずリスト出力
 *************************************************/
// 現在のスラッグ
$current_slug = get_current_slug();

// 現在のページ情報に設定されたパンくず情報
$current_bred = Page::getBreadcrumbs($current_slug);
// nullの場合Postから取得
if (empty($current_bred)) {
    $current_bred = Post::getBreadcrumbs($current_slug);
}

// 画面側から上書きする場合は「$override_bred に定義する」
if(isset($override_bred)) {
    $current_bred = $override_bred;
}

// パンくずの数
$total = count($current_bred);

// インデックス
$index = 0;
?>

<ol class="bl_bred js_bred" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li class="bl_bred_list js_bredList" itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
        <a class="bl_bred_item js_bredItem" itemprop="item" href="<?php echo esc_url(home_url('/')); ?>">
            <span itemprop="name">HOME</span>
        </a>
        <meta itemprop="position" content="1" />
    </li>

    <?php if (is_single()): ?>
        <?php foreach ($current_bred as $slug): ?>
            <?php $index++; ?>
            <li class="bl_bred_list js_bredList" itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                <a class="bl_bred_item js_bredItem" itemprop="item" href=<?php echo get_url($slug) ?>>
                    <span itemprop="name">
                        <?php echo !empty(Post::getTitle($slug)) ? Post::getTitle($slug): Page::getTitle($slug); ?>
                    </span>
                </a>
                <meta itemprop="position" content=<?php echo $index + 1 ?> />
            </li>
        <?php endforeach; ?>
        <li class="bl_bred_list js_bredList" itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <span class="bl_bred_item js_bredItem" itemprop="item">
                <span itemprop="name"><?php echo get_the_title() ?></span>
            </span>
            <meta itemprop="position" content=<?php echo $index + 2 ?> />
        </li>
    <?php else: ?>
        <?php foreach ($current_bred as $slug): ?>
            <?php $index++; ?>
            <li class="bl_bred_list js_bredList" itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                <?php if ($index === $total): ?>
                    <span class="bl_bred_item js_bredItem" itemprop="item">
                        <span itemprop="name">
                            <?php echo !empty(Post::getTitle($slug)) ? Post::getTitle($slug): Page::getTitle($slug); ?>
                        </span>
                    </span>
                <?php else: ?>
                    <a class="bl_bred_item js_bredItem" itemprop="item" href=<?php echo get_url($slug) ?>>
                        <span itemprop="name">
                            <?php echo !empty(Post::getTitle($slug)) ? Post::getTitle($slug): Page::getTitle($slug); ?>
                        </span>
                    </a>
                <?php endif; ?>
                <meta itemprop="position" content=<?php echo $index + 1 ?> />
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ol>