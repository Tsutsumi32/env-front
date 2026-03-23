<?php
  /************************************************
 * 固定ページクラス
 *************************************************/
class Page
{
    // 各画面のキー(スラッグ)
    const TOP                    = 'top';
    const PRODUCTS               = 'products';
    const DEVELOPMENT            = 'development';
    const TRAIDING               = 'traiding';
    const PRODUCTION             = 'production';
    const PRODUCTION_VEHICLE     = "production-vehicle";
    const PRODUCTION_FACTORY     = "production-factory";
    const PRODUCTION_MEDICAL     = "production-medical";
    const PRODUCTION_ENVIRONMENT = "production-environment";
    const PRODUCTION_OFFICE      = "production-office";
    const PRODUCTION_COMMERCIAL  = "production-commercial";
    const PRODUCTION_AMUSEMENT   = "production-amusement";
    const PRODUCTION_AGRICULTURE = "production-agriculture";
    const PRODUCTION_DETAIL      = 'production-detail';
    const RECYCLE                = 'recycle';
    const REARLIGHT              = 'rearlight';
    const COMPANY                = 'company';
    const RECRUIT                = 'recruit';
    const CONTACT                = 'contact';
    const CONTACT_DOWNLOAD       = 'contact-download';
    const CONTACT_THANKS         = 'thanks';
    const CONTACT_ERROR          = 'contact-error';
    const SDGS                   = 'sdgs';
    const PRIVACY_POLICY         = 'privacy-policy';
    const NOT_FOUND              = 'error';

    // 各画面の情報　※ key = slugとする
    protected static $pages = [
        self::TOP => [
            'slug'        => self::TOP,
            'title'       => 'ホーム',
            'description' => 'トップページです',
            'url'         => '/',
            'parent'      => null,
            'breadcrumbs' => [],
            'noindex'     => false,
        ],
        self::PRODUCTS => [
            'slug'        => self::PRODUCTS,
            'title'       => '製品一覧・検索',
            'description' => '当社の製品一覧',
            'url'         => '/products',
            'parent'      => null,
            'breadcrumbs' => [
                self::PRODUCTS
            ],
            'noindex' => false,
        ],
        self::DEVELOPMENT => [
            'slug'        => self::DEVELOPMENT,
            'title'       => 'アクリル製品の企画・開発',
            'description' => '製品開発について',
            'url'         => '/development',
            'parent'      => null,
            'breadcrumbs' => [
                self::DEVELOPMENT
            ],
            'noindex' => false,
        ],
        self::TRAIDING => [
            'slug'        => self::TRAIDING,
            'title'       => 'アクリルの総合商社',
            'description' => '商社事業のご紹介',
            'url'         => '/traiding',
            'parent'      => null,
            'breadcrumbs' => [
                self::TRAIDING
            ],
            'noindex' => false,
        ],
        self::PRODUCTION => [
            'slug'        => self::PRODUCTION,
            'title'       => 'アクリル製品の製造・加工',
            'description' => '国内外の生産拠点紹介',
            'url'         => '/production',
            'parent'      => null,
            'breadcrumbs' => [
                self::PRODUCTION
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_VEHICLE => [
            'slug'        => self::PRODUCTION_VEHICLE,
            'title'       => '乗り物',
            'description' => '乗り物',
            'url'         => '/production/production-vehicle',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_VEHICLE
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_FACTORY => [
            'slug'        => self::PRODUCTION_FACTORY,
            'title'       => '工場',
            'description' => '工場',
            'url'         => '/production/production-factory',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_FACTORY
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_MEDICAL => [
            'slug'        => self::PRODUCTION_MEDICAL,
            'title'       => '医療',
            'description' => '医療',
            'url'         => '/production/production-medical',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_MEDICAL
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_ENVIRONMENT => [
            'slug'        => self::PRODUCTION_ENVIRONMENT,
            'title'       => '環境',
            'description' => '環境',
            'url'         => '/production/production-environment',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_ENVIRONMENT
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_OFFICE => [
            'slug'        => self::PRODUCTION_OFFICE,
            'title'       => '住宅・オフィス',
            'description' => '住宅・オフィス',
            'url'         => '/production/production-office',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_OFFICE
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_COMMERCIAL => [
            'slug'        => self::PRODUCTION_COMMERCIAL,
            'title'       => '商業施設',
            'description' => '商業施設',
            'url'         => '/production/production-commercial',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_COMMERCIAL
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_AMUSEMENT => [
            'slug'        => self::PRODUCTION_AMUSEMENT,
            'title'       => 'アミューズメント',
            'description' => 'アミューズメント',
            'url'         => '/production/production-amusement',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_AMUSEMENT
            ],
            'noindex' => false,
        ],
        self::PRODUCTION_AGRICULTURE => [
            'slug'        => self::PRODUCTION_AGRICULTURE,
            'title'       => '農林産業',
            'description' => '農林産業',
            'url'         => '/production/production-agriculture',
            'parent'      => self::PRODUCTION,
            'breadcrumbs' => [
                self::PRODUCTION,
                self::PRODUCTION_AGRICULTURE
            ],
            'noindex' => false,
        ],
        self::RECYCLE => [
            'slug'        => self::RECYCLE,
            'title'       => 'アクリル製品のリサイクル',
            'description' => '環境対応型の取り組み',
            'url'         => '/recycle',
            'parent'      => null,
            'breadcrumbs' => [
                self::RECYCLE
            ],
            'noindex' => false,
        ],
        self::REARLIGHT => [
            'slug'        => self::REARLIGHT,
            'title'       => '再生アクリル板「リアライト®」',
            'description' => 'リアライト製品情報',
            'url'         => '/rearlight',
            'parent'      => null,
            'breadcrumbs' => [
                self::REARLIGHT
            ],
            'noindex' => false,
        ],
        self::COMPANY => [
            'slug'        => self::COMPANY,
            'title'       => '会社情報',
            'description' => '会社の基本情報',
            'url'         => '/company',
            'parent'      => null,
            'breadcrumbs' => [
                self::COMPANY
            ],
            'noindex' => false,
        ],
        self::RECRUIT => [
            'slug'        => self::RECRUIT,
            'title'       => '採用情報',
            'description' => '採用に関する情報',
            'url'         => '/recruit',
            'parent'      => null,
            'breadcrumbs' => [
                self::RECRUIT
            ],
            'noindex' => false,
        ],
        self::CONTACT => [
            'slug'        => self::CONTACT,
            'title'       => 'お問い合わせ',
            'description' => 'お問い合わせページ',
            'url'         => '/contact',
            'parent'      => null,
            'breadcrumbs' => [
                self::CONTACT
            ],
            'noindex' => false,
        ],
        self::CONTACT_DOWNLOAD => [
            'slug'        => self::CONTACT_DOWNLOAD,
            'title'       => 'ダウンロードフォーム',
            'description' => 'ダウンロードフォーム',
            'url'         => '/contact-download',
            'parent'      => null,
            'breadcrumbs' => [
                self::CONTACT_DOWNLOAD
            ],
            'noindex' => true,
        ],
        self::CONTACT_THANKS => [
            'slug'        => self::CONTACT_THANKS,
            'title'       => 'お問い合わせ完了',
            'description' => 'お問い合わせページ',
            'url'         => '/contact/thanks',
            'parent'      => self::CONTACT,
            'breadcrumbs' => [
                self::CONTACT
            ],
            'noindex' => true,
        ],
        self::CONTACT_ERROR => [
            'slug'        => self::CONTACT_ERROR,
            'title'       => 'お問い合わせエラー',
            'description' => 'お問い合わせページ',
            'url'         => '/contact-error',
            'parent'      => null,
            'breadcrumbs' => [
                self::CONTACT
            ],
            'noindex' => true,
        ],
        self::SDGS => [
            'slug'        => self::SDGS,
            'title'       => 'サステナビリティ',
            'description' => 'サステナビリティへの取り組み',
            'url'         => '/sdgs',
            'parent'      => null,
            'breadcrumbs' => [
                self::SDGS
            ],
            'noindex' => false,
        ],
        self::PRIVACY_POLICY => [
            'slug'        => self::PRIVACY_POLICY,
            'title'       => 'プライバシーポリシー',
            'description' => '個人情報保護方針',
            'url'         => '/privacy-policy',
            'parent'      => null,
            'breadcrumbs' => [
                self::PRIVACY_POLICY
            ],
            'noindex' => false,
        ],
        self::NOT_FOUND => [
            'slug'        => self::NOT_FOUND,
            'title'       => '404 NOT FOUND',
            'description' => 'ページが見つかりませんでした',
            'url'         => '',
            'parent'      => null,
            'breadcrumbs' => [],
            'noindex'     => true,
        ],
    ];


    /**
     * 画面情報取得
     */
    public static function get(string $key): ?array
    {
        return self::$pages[$key] ?? null;
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
     * 親画面スラッグ取得
     */
    public static function getParent(string $key): ?string
    {
        return self::get($key)['parent'] ?? null;
    }

    /**
     * 全情報取得
     */
    public static function getAll(): array
    {
        return self::$pages;
    }

    /**
     * WP-CLI用のページ定義（タイトル, スラッグ, 親スラッグ）を配列にし、1行ずつ文字列として出力する
     */
    public static function forCli()
    {
        $output = [];

        foreach (self::getAll() as $key => $data) {
            $output[] = implode(':', [
                $data['title'],
                $data['slug'],
                $data['parent'] ?? ''
            ]);
        }

        foreach ($output as $line) {
            echo $line . PHP_EOL;
        }
    }
}
