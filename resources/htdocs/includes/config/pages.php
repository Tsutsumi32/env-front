<?php
/**
 * 各画面の設定値を定義するクラス
 *
 * このクラスでは、各ページの設定値（タイトル、ディスクリプション、パンくずリスト、URL等）を管理します。
 * Pageクラスとして、各ページの設定を定義します。
 */

/**
 * ページ設定クラス
 */
class Page
{
    /**
     * 画面キー定数
     */
    public const PAGE_SAMPLE = 'sample';
    public const PAGE_SAMPLE_ABOUT = 'sample-about';
    public const PAGE_SAMPLE_WORKS = 'sample-works';

    /**
     * ページ設定の配列（キーがページID）
     * @var array
     */
    private static $pages = [
        self::PAGE_SAMPLE => [
            'title' => 'サンプルトップ',
            'description' => 'サンプルサイトのトップページです。',
            'breadcrumbs' => [
                ['name' => 'ホーム', 'url' => '/']
            ],
            'url' => '/',
            'noindex' => false,
        ],
        self::PAGE_SAMPLE_ABOUT => [
            'title' => 'About - サンプルサイト',
            'description' => 'このサイトについてのページです。',
            'breadcrumbs' => [
                ['name' => 'ホーム', 'url' => '/'],
                ['name' => 'About', 'url' => '/about.php']
            ],
            'url' => '/about.php',
            'noindex' => false,
        ],
        self::PAGE_SAMPLE_WORKS => [
            'title' => 'Works - サンプルサイト',
            'description' => '制作実績のページです。',
            'breadcrumbs' => [
                ['name' => 'ホーム', 'url' => '/'],
                ['name' => 'Works', 'url' => '/works.php']
            ],
            'url' => '/works.php',
            'noindex' => false,
        ],
    ];

    /**
     * 現在のリクエストURLからページIDを取得
     *
     * @return string|null ページID（該当なしの場合は null）
     */
    public static function getPageIdFromRequest()
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        // トップ: '' / '/' / '/index.php' を同一扱い
        if ($path === '' || $path === '/' || $path === '/index.php') {
            $path = '/';
        }
        foreach (self::$pages as $pageId => $page) {
            if (($page['url'] ?? '') === $path) {
                return $pageId;
            }
        }
        return null;
    }

    /**
     * ページIDから設定を取得
     *
     * @param string $pageId ページID
     * @return array|null ページ設定配列
     */
    public static function get($pageId)
    {
        return self::$pages[$pageId] ?? null;
    }

    /**
     * ページタイトルを取得
     *
     * @param string $pageId ページID
     * @return string ページタイトル
     */
    public static function getTitle($pageId)
    {
        $page = self::get($pageId);
        return $page['title'] ?? 'Sample Site';
    }

    /**
     * ページディスクリプションを取得
     *
     * @param string $pageId ページID
     * @return string ページディスクリプション
     */
    public static function getDescription($pageId)
    {
        $page = self::get($pageId);
        return $page['description'] ?? '';
    }

    /**
     * パンくずリストを取得
     *
     * @param string $pageId ページID
     * @return array パンくずリスト
     */
    public static function getBreadcrumbs($pageId)
    {
        $page = self::get($pageId);
        return $page['breadcrumbs'] ?? [];
    }

    /**
     * ページURLを取得
     *
     * @param string $pageId ページID
     * @return string ページURL
     */
    public static function getUrl($pageId)
    {
        $page = self::get($pageId);
        return $page['url'] ?? '/';
    }

    /**
     * noindex設定を取得
     *
     * @param string $pageId ページID
     * @return bool noindex設定
     */
    public static function getNoindex($pageId)
    {
        $page = self::get($pageId);
        return (bool) ($page['noindex'] ?? false);
    }
}

