<?php
/************************************************
 * カスタム投稿クラス
 *************************************************/
class Post
{
    const NEWS = 'news';
    const PRODUCT = 'product';
    const PROCESSED_PRODUCTION = 'processed-production';

    // カスタム投稿情報
    protected static $posts = [
        self::NEWS => [
            // カスタム投稿の基本設定
            'slug' => self::NEWS,
            'title' => 'お知らせ',
            'description' => 'お知らせ一覧ページです。',
            'url' => '/news',
            'noindex' => false,
            'breadcrumbs' => [
                self::NEWS
            ],
            // カスタム投稿の登録に必要な設定
            'post_type_settings' => [
                'label' => 'お知らせ',
                'supports' => ['title', 'editor', 'revisions', 'custom-fields', 'page-attributes'],
                'menu_position' => 2,
                'has_archive' => true,
                // 本文編集機能を削除する(ACFのみ利用)
                'remove_editor' => true,
            ],
            // カスタム投稿のタクソノミー(カテゴリ)設定
            'category_settings' => [
                'slug' => 'news-category',
                'default' => [
                    'slug' => 'event',
                    'label' => 'イベント・展示会情報',
                ],
            ],
            // 登録するターム(カテゴリ)設定 WPに反映させるにはwp-create-postsを実行する
            'term_settings' => [
                [
                    'slug' => 'event',
                    'label' => 'イベント・展示会情報',
                    'order' => 1,
                ],
                [
                    'slug' => 'column',
                    'label' => '技術コラム',
                    'order' => 2,
                ],
                [
                    'slug' => 'media',
                    'label' => 'メディア掲載情報',
                    'order' => 3,
                ],
                [
                    'slug' => 'campaign',
                    'label' => 'キャンペーン情報',
                    'order' => 4,
                ],
            ]
        ],
        self::PRODUCT => [
            'slug' => self::PRODUCT,
            'title' => '製品',
            'description' => '製品一覧ページです。',
            'url' => '/products',
            'noindex' => false,
            'breadcrumbs' => [
                Page::PRODUCTS
            ],
            'post_type_settings' => [
                'label' => '製品',
                'supports' => ['title', 'editor', 'revisions', 'custom-fields', 'page-attributes'],
                'menu_position' => 2,
                'has_archive' => false,
                'remove_editor' => true,
            ],
            'category_settings' => [
                'slug' => '',
                'default' => [
                    'slug' => '',
                    'label' => '',
                ],
            ],
            'term_settings' => [
                [
                    'slug' => '',
                    'label' => '',
                    'order' => '',
                ],
            ]
        ],
        self::PROCESSED_PRODUCTION => [
            'slug' => self::PROCESSED_PRODUCTION,
            'title' => '加工/施工 製品',
            'description' => '加工/施工 製品一覧ページです。',
            'url' => '/products',
            'noindex' => false,
            'breadcrumbs' => [
                // 画面側で定義
                ''
            ],
            'post_type_settings' => [
                'label' => '加工/施工 製品',
                'supports' => ['title', 'editor', 'revisions', 'custom-fields', 'page-attributes'],
                'menu_position' => 3,
                'has_archive' => false,
                'remove_editor' => true,
            ],
            'category_settings' => [
                'slug' => '',
                'default' => [
                    'slug' => '',
                    'label' => '',
                ],
            ],
            'term_settings' => [
                [
                    'slug' => '',
                    'label' => '',
                    'order' => '',
                ],
            ]
        ],
    ];

    /**
     * カスタム投稿情報取得
     */
    public static function get(string $key): ?array
    {
        return self::$posts[$key] ?? null;
    }

    /**
     * タイトル取得
     */
    public static function getTitle(string $key): ?string
    {
        return self::get($key)['title'] ?? null;
    }


    /**
     * URL取得
     */
    public static function getUrl(string $key): ?string
    {
        return self::get($key)['url'] ?? null;
    }

    /**
     * ディスクリプション取得
     */
    public static function getDescription(string $key): ?string
    {
        return self::get($key)['description'] ?? null;
    }

    /**
     * パンくず情報取得
     */
    public static function getBreadcrumbs(string $key): array
    {
        return self::get($key)['breadcrumbs'] ?? [];
    }

    /**
     * noindex取得
     */
    public static function getNoindex(string $key): bool
    {
        return self::get($key)['noindex'] ?? false;
    }

    /**
     * 設定情報取得
     */
    public static function getPostTypeSettings(string $key): ?array
    {
        return self::get($key)['post_type_settings'] ?? null;
    }

    /**
     * カテゴリ設定情報取得
     */
    public static function getCategorySettings(string $key): ?array
    {
        return self::get($key)['category_settings'] ?? null;
    }

    /**
     * 各カテゴリー(ターム)取得
     */
    public static function getTermSettings(string $key): ?array
    {
        return self::get($key)['term_settings'] ?? null;
    }

    /**
     * 全情報を取得
     */
    public static function getAll(): array
    {
        return self::$posts;
    }

    /**
     * WP-CLI側に出力する処理(サンプル記事の生成)
     */
    public static function exportBashAssociativeArray(): void
    {
        echo "declare -A POST_TYPES=(" . PHP_EOL;

        foreach (self::$posts as $typeKey => $config) {
            $prefix = str_replace('.', '_', $typeKey); // 念のためドット除去

            echo "  [${prefix}_slug]=\"{$config['slug']}\"" . PHP_EOL;
            echo "  [${prefix}_label]=\"{$config['title']}\"" . PHP_EOL;
            echo "  [${prefix}_category_slug]=\"{$config['category_settings']['slug']}\"" . PHP_EOL;

            foreach ($config['term_settings'] as $term) {
                $slug = $term['slug'];
                $label = $term['label'];
                $order = $term['order'];
                echo "  [${prefix}_term_${slug}_slug]=\"$slug\"" . PHP_EOL;
                echo "  [${prefix}_term_${slug}_label]=\"$label\"" . PHP_EOL;
                echo "  [${prefix}_term_${slug}_order]=\"$order\"" . PHP_EOL;
            }

            if (!empty($config['category_settings']['slug'])) {
                echo "  [${prefix}_category_slug]=\"{$config['category_settings']['slug']}\"" . PHP_EOL;
            }

            if (!empty($config['post_type_settings']['has_archive'])) {
                echo "  [${prefix}_has_archive]=\"{$config['post_type_settings']['has_archive']}\"" . PHP_EOL;
            }
        }

        echo ")" . PHP_EOL;
    }
}
