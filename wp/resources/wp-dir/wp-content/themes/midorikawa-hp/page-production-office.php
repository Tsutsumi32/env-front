<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_OFFICE;
$head_contents = [
    'head' => '住宅/オフィス',
    'en' => 'Housing / Office',
    'intro' => '暮らしと働く場に、<br class="hp_nonePc">快適性と機能美を。',
    'text' => '内装材や間仕切り、収納パーツなど、住宅・オフィス空間を彩る多彩な樹脂製品をご提供。空間設計に合わせた素材選定から加工・納品まで、一貫体制でサポートします。'
];

$items = [
    [
        'head' => '住宅',
        'intro' => '住宅空間では、快適性・安全性・意匠性のバランスが重要です。緑川化成グループは、内装材・間仕切り・浴室パーツなど多彩な住宅向け樹脂製品を、デザイン性と機能性を両立して提供。高品質な住まいづくりに貢献します。',
        'processing_type' => 'house_office_house',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '耐候性・断熱性・防汚性など、住宅用途に適した機能性樹脂を豊富に取り揃え、空間の用途や目的に合わせてご提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '間仕切り、パネル、収納扉などに対し、真空成形・射出成形・切削・接着などの加工技術で柔軟に対応します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '玄関・キッチン・洗面室・リビングなどで使われる壁面材・収納部材・装飾パネル・ドア部材などへの応用が可能です。'
            ],
            [
                'head' => '快適性と安全性',
                'en' => 'Comfort & Safety',
                'text' => '清掃性の高い素材や衝撃に強い製品、安全性に配慮した加工設計により、安心で快適な住空間づくりを支援します。'
            ],
        ],
    ],
    [
        'head' => 'オフィス',
        'intro' => '快適で機能的なオフィス環境には、デザイン性と安全性を兼ね備えた素材が求められます。緑川化成グループは、デスク周りの間仕切りやパーテーション、受付カウンターなど、空間設計に沿った多様な樹脂製品をご提案します。',
        'processing_type' => 'house_office_office',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '視認性・遮音性・耐傷性・意匠性など、オフィスの使用環境や目的に応じた樹脂素材を豊富にラインナップ。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => 'パーテーション、パネル、受付カウンターなどに対し、切削・接着・曲げ加工・印刷など多彩な加工技術で対応。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '機能性とデザイン性を兼ね備えた空間づくりに活用されています。'
            ],
            [
                'head' => '働きやすさの<br class="hp_noneSp">追求',
                'en' => 'Material Proposal',
                'text' => '快適な作業環境を支える製品を開発。多様な働き方に対応する空間づくりを支援します。'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>