<?php
if (!defined('ABSPATH')) exit;

/************************************************
 * ACFフィールドクラス
 *************************************************/
class AcfField
{
    const NEWS  = Post::NEWS;
    const PRODUCT = Post::PRODUCT;
    const PROCESSED_PRODUCTION = Post::PROCESSED_PRODUCTION;

    const NEWS_PREFIX = 'news_';
    const PRODUCT_PREFIX = 'product_';
    const PROCESSED_PRODUCTION_PREFIX = 'processed-production_';

    const PRODUCT_CONTENTS_COUNT = 5;
    const PRODUCT_IMAGE_COUNT = 10;
    const PRODUCT_PROCESSING_CONTENTS_COUNT = 1;
    const PRODUCT_PROCESSING_CONTENTS_COUNT_PER_ITEM = 4;
    const PROCESSED_PRODUCTION_IMAGE_COUNT = 10;

    protected static ?int $sampleImageId = null;

    protected static array $acf_fields = [];
    protected static array $acf_settings = [];

    /**
     * 初期化処理：フィールドと設定を動的に構築
     */
    public static function init(): void
    {
        // 最新画像を取得して sampleImageId に設定
        $latest_image = get_posts([
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        self::$sampleImageId = $latest_image[0]->ID ?? null;

        // ACF フィールド定義
        self::$acf_fields = [
            self::NEWS => [
                [
                    'slug'              => self::NEWS_PREFIX . 'image',
                    'label'             => '画像',
                    'type'              => 'image',
                    'instruction'       => '',
                    'default_value'     => '',
                    'placeholder'       => '',
                    'conditional_logic' => '',
                    // サンプル記事に設定する値。チェックボックス等は、配列で渡すことでランダムに設定される
                    'sample'            => self::$sampleImageId,
                ],
                [
                    'slug'              => self::NEWS_PREFIX . 'detail',
                    'label'             => '本文',
                    'type'              => 'textarea',
                    'instruction'       => '',
                    'default_value'     => '',
                    'placeholder'       => '',
                    'conditional_logic' => '',
                    'sample'            => "ホームページをリニューアルしました。\n何卒よろしくお願い申し上げます。",
                ],
            ],
            self::PRODUCT => [
                // 以下、画像フィールドを動的に追加
                ...self::generateImageFields(self::PRODUCT_IMAGE_COUNT, self::PRODUCT_PREFIX),
                [
                    'slug'              => self::PRODUCT_PREFIX . 'pickup',
                    'label'             => 'おすすめ製品',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'choices'           => [
                        1 => 'おすすめ製品に表示'
                    ],
                ],
                [
                    'slug'              => self::PRODUCT_PREFIX . 'category',
                    'label'             => 'カテゴリ',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'choices'           => ListItems::getProductCategories(),
                    'sample'            => [
                        '1',
                    ],
                ],
                [
                    'slug'              => self::PRODUCT_PREFIX . 'mk_category',
                    'label'             => 'MKブランド製品カテゴリ',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'choices'           => ListItems::getProductMkCategories(),
                    'sample'            => [
                        '1',
                    ],
                ],
                [
                    'slug'              => self::PRODUCT_PREFIX . 'tag',
                    'label'             => 'タグ',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'choices'           => ListItems::getProductTags(),
                    'sample'            => [
                        '1',
                    ],
                ],
                [
                    'slug'              => self::PRODUCT_PREFIX . 'overview',
                    'label'             => '製品 概要',
                    'type'              => 'textarea',
                    'instruction'       => '',
                    'required'          => 1,
                    'default_value'     => '',
                    'placeholder'       => '',
                    'conditional_logic' => '',
                    'sample'            => "耐久性に優れたFRP製の板。強力な防水性と耐熱性を兼ね備え、屋外環境でも長期間の使用が可能です。"
                ],
                // 以下、製品項目のフィールドを動的に追加
                ...self::generateContentsFields(self::PRODUCT_CONTENTS_COUNT),
                [
                    'slug'              => self::PRODUCT_PREFIX . 'catalog_type',
                    'label'             => 'カタログ区分',
                    'type'              => 'radio',
                    'instructions'      => '',
                    'required'          => 1,
                    'choices'           => [
                        'pdf' => 'PDF',
                        'external' => '外部サイト',
                        'form' => 'ダウンロードフォーム'
                    ],
                    'default_value'     => 'pdf',
                    'sample'            => 'pdf',
                ],
                [
                    'slug'              => self::PRODUCT_PREFIX . 'pdf',
                    'label'             => 'PDFを選択した場合はこちらにPDFをアップロードしてください',
                    'type'              => 'file',
                    'instruction'       => '',
                    'required'          => 0,
                    'mime_types'        => 'pdf,doc,docx,xls,xlsx',
                    'conditional_logic' => [
                        [
                            [
                                'field' => self::PRODUCT_PREFIX . 'catalog_type',
                                'operator' => '==',
                                'value' => 'pdf',
                            ],
                        ],
                    ],
                    'sample'            => '',
                ],
                [
                    'slug'              => self::PRODUCT_PREFIX . 'external',
                    'label'             => '外部サイトを選択した場合はこちらにリンクURLを入力してください',
                    'type'              => 'text',
                    'instruction'       => '',
                    'required'          => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => self::PRODUCT_PREFIX . 'catalog_type',
                                'operator' => '==',
                                'value' => 'external',
                            ],
                        ],
                    ],
                    'sample'            => '',
                ],
            ],
            self::PROCESSED_PRODUCTION => [
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'processing_type',
                    'label'             => '加工/施工 区分',
                    'type'              => 'radio',
                    'instructions'      => '',
                    'required'          => 1,
                    'choices'           => ListItems::getProductProcessingTypes(),
                    'default_value'     => 'vehicle_car',
                    'sample'            => 'vehicle_car',
                ],
                // 以下、画像フィールドを動的に追加
                ...self::generateImageFields(self::PROCESSED_PRODUCTION_IMAGE_COUNT, self::PROCESSED_PRODUCTION_PREFIX),
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'category',
                    'label'             => 'カテゴリ',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'choices'           => ListItems::getProductCategories(),
                    'sample'            => [
                        '1',
                    ],
                ],
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'mk_category',
                    'label'             => 'MKブランド製品カテゴリ',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'choices'           => ListItems::getProductMkCategories(),
                    'sample'            => [
                        '1',
                    ],
                ],
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'tag',
                    'label'             => 'タグ',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'choices'           => ListItems::getProductTags(),
                    'sample'            => [
                        '1',
                    ],
                ],
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'overview_title',
                    'label'             => '加工/施工 タイトル',
                    'type'              => 'text',
                    'instruction'       => '',
                    'required'          => 1,
                    'default_value'     => '',
                    'placeholder'       => '',
                    'sample'            => "サンプルタイトル",
                ],
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'overview',
                    'label'             => '加工/施工 概要',
                    'type'              => 'textarea',
                    'instruction'       => '',
                    'required'          => 1,
                    'default_value'     => '',
                    'placeholder'       => '',
                    'conditional_logic' => '',
                    'sample'            => "耐久性に優れたFRP製の板。強力な防水性と耐熱性を兼ね備え、屋外環境でも長期間の使用が可能です。"
                ],
                // 以下、加工/施工項目のフィールドを動的に追加
                ...self::generateProcessingContentsFields(self::PRODUCT_PROCESSING_CONTENTS_COUNT),
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'catalog_type',
                    'label'             => 'カタログ区分',
                    'type'              => 'radio',
                    'instructions'      => '',
                    'required'          => 1,
                    'choices'           => [
                        'pdf' => 'PDF',
                        'external' => '外部サイト',
                        'form' => 'ダウンロードフォーム'
                    ],
                    'default_value'     => 'pdf',
                    'sample'            => 'pdf',
                ],
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'pdf',
                    'label'             => 'PDFを選択した場合はこちらにPDFをアップロードしてください',
                    'type'              => 'file',
                    'instruction'       => '',
                    'required'          => 0,
                    'mime_types'        => 'pdf,doc,docx,xls,xlsx',
                    'conditional_logic' => [
                        [
                            [
                                'field' => self::PROCESSED_PRODUCTION_PREFIX . 'catalog_type',
                                'operator' => '==',
                                'value' => 'pdf',
                            ],
                        ],
                    ],
                    'sample'            => '',
                ],
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'external',
                    'label'             => '外部サイトを選択した場合はこちらにリンクURLを入力してください',
                    'type'              => 'text',
                    'instruction'       => '',
                    'required'          => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => self::PROCESSED_PRODUCTION_PREFIX . 'catalog_type',
                                'operator' => '==',
                                'value' => 'external',
                            ],
                        ],
                    ],
                    'sample'            => '',
                ],
                [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . 'overview',
                    'label'             => '加工/施工 概要',
                    'type'              => 'textarea',
                    'instruction'       => '',
                    'required'          => 1,
                    'default_value'     => '',
                    'placeholder'       => '',
                    'conditional_logic' => '',
                    'sample'            => "耐久性に優れたFRP製の板。強力な防水性と耐熱性を兼ね備え、屋外環境でも長期間の使用が可能です。"
                ],
            ],
        ];

        // ACF 設定定義
        self::$acf_settings = [
            self::NEWS => [
                'slug'      => self::NEWS_PREFIX . 'field',
                'label'     => 'お知らせ_設定項目',
                'post_type' => self::NEWS,
                'items'     => self::getField(self::NEWS),
                // 管理画面上の一覧上に表示される画像
                'thumbnail' => 'news_image'
            ],
            self::PRODUCT => [
                'slug'      => self::PRODUCT_PREFIX . 'field',
                'label'     => '製品情報_設定項目',
                'post_type' => self::PRODUCT,
                'items'     => self::getField(self::PRODUCT),
                'thumbnail' => 'product_image'
            ],
            self::PROCESSED_PRODUCTION => [
                'slug'      => self::PROCESSED_PRODUCTION_PREFIX . 'field',
                'label'     => '製品情報_設定項目',
                'post_type' => self::PROCESSED_PRODUCTION,
                'items'     => self::getField(self::PROCESSED_PRODUCTION),
                'thumbnail' => 'product_image'
            ],
        ];
    }

    /**
     * 画像フィールドを動的に生成
     */
    public static function generateImageFields($count = 10, $prefix)
    {
        $array = [];

        for ($i = 1; $i <= $count; $i++) {
            $array[] = [
                'slug'              => $prefix . "image{$i}",
                'label'             => "画像{$i}",
                'type'              => 'image',
                'instruction'       => '',
                'default_value'     => '',
                'placeholder'       => '',
                'conditional_logic' => '',
                'sample'            => self::$sampleImageId,
            ];
        }
        return $array;
    }

    /**
     * 製品項目フィールドを動的に生成
     */
    public static function generateContentsFields($count = 1)
    {
        $array = [];

        for ($i = 1; $i <= $count; $i++) {
            // 項目タイトルフィールド
            $array[] = [
                'slug'              => self::PRODUCT_PREFIX . "contents{$i}_title",
                'label'             => "<h3>[項目{$i}]</h3><br>タイトル",
                'type'              => 'text',
                'instruction'       => '',
                'default_value'     => '',
                'placeholder'       => '',
                'sample'            => "サンプルタイトル{$i}",
            ];

            // 項目本文フィールド
            $array[] = [
                'slug'              => self::PRODUCT_PREFIX . "contents{$i}_text",
                'label'             => "本文",
                'type'              => 'textarea',
                'instruction'       => '',
                'default_value'     => '',
                'placeholder'       => '',
                'sample'            => "サンプル本文{$i}",
            ];
        }
        return $array;
    }
    /**
     * 加工/施工項目フィールドを動的に生成
     */
    public static function generateProcessingContentsFields($count = 1)
    {
        $array = [];

        for ($i = 1; $i <= $count; $i++) {
            // 加工/施工項目タイトルフィールド
            $array[] = [
                'slug'              => self::PROCESSED_PRODUCTION_PREFIX . "contents{$i}_title",
                'label'             => "<h3>[項目{$i}]</h3><br>タイトル",
                'type'              => 'text',
                'instruction'       => '',
                'default_value'     => '',
                'placeholder'       => '',
                'sample'            => "サンプルタイトル{$i}",
            ];
            for ($j = 1; $j <= self::PRODUCT_PROCESSING_CONTENTS_COUNT_PER_ITEM; $j++) {
                // 加工/施工項目本文タイトルフィールド
                $array[] = [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . "contents{$i}_title{$j}",
                    'label'             => "見出し{$j}",
                    'type'              => 'text',
                    'instruction'       => '',
                    'default_value'     => '',
                    'placeholder'       => '',
                    'sample'            => "サンプル見出し{$i}",
                ];
                // 加工/施工項目本文フィールド
                $array[] = [
                    'slug'              => self::PROCESSED_PRODUCTION_PREFIX . "contents{$i}_text{$j}",
                    'label'             => "本文{$j}",
                    'type'              => 'textarea',
                    'instruction'       => '',
                    'default_value'     => '',
                    'placeholder'       => '',
                    'sample'            => "サンプル本文{$i}",
                ];
            }
        }
        return $array;
    }
    /**
     * 指定投稿タイプの ACF フィールドを取得
     */
    public static function getField(string $key): ?array
    {
        return self::$acf_fields[$key] ?? null;
    }

    /**
     * 指定投稿タイプの ACF 設定を取得
     */
    public static function getSetting(string $key): ?array
    {
        return self::$acf_settings[$key] ?? null;
    }

    /**
     * すべてのフィールド定義を取得
     */
    public static function getAllFields(): array
    {
        return self::$acf_fields;
    }

    /**
     * すべての設定定義を取得
     */
    public static function getAllSettings(): array
    {
        return self::$acf_settings;
    }
}
