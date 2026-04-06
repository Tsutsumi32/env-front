<?php
/**
 * ヘッダーコンポーネント
 *
 * このファイルでは、サイト全体で使用するヘッダーを定義します。
 * ナビゲーション、ロゴ、ダークモード切替ボタンなどを含みます。
 */
?>

<header class="ly_header has_header" data-module="header">
    <div class="ly_container __medium">
        <div class="ly_header_inner">
            <div class="ly_header_logo">
                <a href="/" class="ly_header_logoLink"></a>
            </div>
            <nav class="ly_header_nav" aria-label="メインナビゲーション">
                <ul class="ly_header_navList">
                    <li class="ly_header_navItem">
                        <a href="/" class="ly_header_navLink">ホーム</a>
                    </li>
                    <li class="ly_header_navItem">
                        <a href="/about.php" class="ly_header_navLink">About</a>
                    </li>
                    <li class="ly_header_navItem">
                        <a href="/works.php" class="ly_header_navLink">Works</a>
                    </li>
                </ul>
            </nav>
            <div class="ly_header_actions">
                <button type="button" class="ly_header_themeToggle ly_header_themeToggle__dark" data-module="themeToggle" data-action="themeToggle.toggle" data-theme-toggle-theme="dark" aria-label="ダークモードに切替">
                    <span class="ly_header_themeToggleIcon">🌙</span>
                </button>
                <button type="button" class="ly_header_themeToggle ly_header_themeToggle__light" data-module="themeToggle" data-action="themeToggle.toggle" data-theme-toggle-theme="default" aria-label="ライトモードに切替">
                    <span class="ly_header_themeToggleIcon">☀️</span>
                </button>
            </div>
        </div>
    </div>
</header>

