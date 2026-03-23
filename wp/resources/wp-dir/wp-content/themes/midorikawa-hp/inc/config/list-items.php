<?php
if (!defined("ABSPATH")) exit;
class ListItems
{
    /***************************************************
    製品タグ
     ****************************************************/
    // 製品タグ（tags）
    private static array $product_tags = [
        1 => 'アクリル',
        2 => '塩ビ',
        3 => 'ポリカ',
        4 => 'PET',
        5 => 'ABS',
        6 => '建材',
        7 => 'FRP',
        8 => 'PP/PE',
        9 => 'アルミ複合板',
        10 => '特殊板',
        11 => 'LED/電材',
        12 => 'エンジニアリングプラスチック',
        13 => '導光板',
        14 => 'マーキングフィルム',
        15 => '内装用シート',
        16 => 'ガラスフィルム',
        17 => 'デジタルプリント用メディア',
        999 => 'その他',
    ];
    // product_tags を返す
    public static function getProductTags(): array
    {
        return self::$product_tags;
    }
    // key に一致する name を返す
    public static function getProductTagName($key): ?string
    {
        return self::$product_tags[$key] ?? null; // 一致するキーがなければ null を返す
    }

    /***************************************************
    製品カテゴリ
     ****************************************************/
    private static array $product_categories = [
        1 => 'MKブランド製品',
        2 => '新製品',
        3 => '環境配慮型製品',
        4 => '飛沫対策製品',
        5 => '抗菌・抗ウイルス製品',
    ];
    // categories を返す
    public static function getProductCategories(): array
    {
        return self::$product_categories;
    }
    // key に一致する name を返す
    public static function getProductCategoryName($key): ?string
    {
        return self::$product_categories[$key] ?? null; // 一致するキーがなければ null を返す
    }
    /***************************************************
    MKブランド製品カテゴリ
     ****************************************************/
    private static array $product_mk_categories = [
        1 => '塩化ビニールプレート',
        2 => '塩ビミラー',
        3 => 'アクリル板',
        4 => 'ペレット',
        5 => 'フッ素樹脂',
        6 => 'プリズムシート',
        7 => '再生バンド',
        8 => '建築資材',
        9 => 'マグネットシート',
        10 => '透ける竹',
        11 => '接着剤',
        12 => '仕切り・パーテーション',
    ];
    // categories を返す
    public static function getProductMkCategories(): array
    {
        return self::$product_mk_categories;
    }
    // key に一致する name を返す
    public static function getProductMkCategoryName($key): ?string
    {
        return self::$product_mk_categories[$key] ?? null; // 一致するキーがなければ null を返す
    }
    /***************************************************
    加工/施工区分
     ****************************************************/
    private static array $product_processing_types = [
        'vehicle_car'               => '乗り物：自動車/二輪車',
        'vehicle_train'             => '乗り物：鉄道/バス',
        'vehicle_machine'           => '乗り物：建機',
        'vehicle_aircraft'          => '乗り物：航空機',
        'factory_machine'           => '工場：産業機械/ライン・プラント',
        'factory_parts'             => '工場：製品部品',
        'medical_equipment'         => '医療：医療機器',
        'medical_container'         => '医療：医療品容器',
        'medical_sanitary'          => '医療：衛生用品',
        'environment_regeneration'  => '環境：再生材料',
        'environment_energy'        => '環境：省エネルギー',
        'environment_recycle'       => '環境：回収リサイクル',
        'house_office_house'        => '住宅・オフィス：住宅',
        'house_office_office'       => '住宅・オフィス：オフィス',
        'facility_shopping'         => '商業施設：ショッピングモール',
        'facility_convenience'      => '商業施設：コンビニエンスストア',
        'facility_restaurant'       => '商業施設：レストラン',
        'facility_cosmetics'        => '商業施設：コスメショップ',
        'amusement_arcade'          => 'アミューズメント：アーケードゲーム機',
        'amusement_pachinko'        => 'アミューズメント：パチンコ',
        'amusement_attraction'      => 'アミューズメント：アトラクション',
        'agriculture_agriculture'   => '農水産業：農業資材',
        'agriculture_aquaculture'   => '農水産業：漁業資材',
    ];
    // processing_types を返す
    public static function getProductProcessingTypes(): array
    {
        return self::$product_processing_types;
    }
    // key に一致する name を返す
    public static function getProductProcessingTypeName($key): ?string
    {
        return self::$product_processing_types[$key] ?? null; // 一致するキーがなければ null を返す
    }
}
