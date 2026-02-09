<?php
/**
 * 各画面の設定値を定義するクラス
 *
 * このクラスでは、各ページの設定値（タイトル、ディスクリプション、パンくずリスト、URL等）を管理します。
 * PageConfigクラスとして、各ページの設定を定義します。
 */

/**
 * ページID定数
 */
class PAGE_ID
{
    const SAMPLE = 'sample';
    const SAMPLE_ABOUT = 'sample-about';
    const SAMPLE_WORKS = 'sample-works';
}

/**
 * ページ設定クラス
 */
class PageConfig
{
    /**
     * ページ設定の配列
     * @var array
     */
    private static $pages = [
        PAGE_ID::SAMPLE => [
            'title' => 'サンプルトップ',
            'description' => 'サンプルサイトのトップページです。',
            'breadcrumbs' => [
                ['name' => 'ホーム', 'url' => '/']
            ],
            'url' => '/',
        ],
        PAGE_ID::SAMPLE_ABOUT => [
            'title' => 'About - サンプルサイト',
            'description' => 'このサイトについてのページです。',
            'breadcrumbs' => [
                ['name' => 'ホーム', 'url' => '/'],
                ['name' => 'About', 'url' => '/about.php']
            ],
            'url' => '/about.php',
        ],
        PAGE_ID::SAMPLE_WORKS => [
            'title' => 'Works - サンプルサイト',
            'description' => '制作実績のページです。',
            'breadcrumbs' => [
                ['name' => 'ホーム', 'url' => '/'],
                ['name' => 'Works', 'url' => '/works.php']
            ],
            'url' => '/works.php',
        ],
    ];

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
}

