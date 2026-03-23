<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_COMMERCIAL;
$head_contents = [
    'head' => '商業施設',
    'en' => 'Commercial Facility',
    'intro' => '空間の魅力を引き出す、<br class="hp_nonePc">機能とデザインを両立。',
    'text' => '店舗什器、ディスプレイ、サインなど、商業空間に求められる美しさと耐久性を兼ね備えた製品を提供。用途に応じた素材提案から加工・施工まで、ワンストップで対応します。'
];

$items = [
    [
        'head' => 'ショッピングモール',
        'intro' => '商業施設の空間演出において、意匠性・耐久性・安全性を兼ね備えた樹脂製品は欠かせません。緑川化成グループは、館内サイン、什器、パーテーションなどの多様な用途に合わせ、設計段階から素材選定・加工・施工までワンストップで対応します。',
        'processing_type' => 'facility_shopping',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '視認性・耐衝撃性・意匠性に優れたアクリルやポリカーボネートをはじめ、空間用途に応じた素材をご提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => 'レーザー加工や曲げ・接着・印刷など、デザイン性と強度を両立する加工技術で、多様な造作物を実現します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '案内サイン、飛沫防止パネル、什器、照明パネル、ディスプレイ装飾など、施設のあらゆる空間で活用されています。'
            ],
            [
                'head' => 'デザイン性と<br class="hp_noneSp">快適性の両立',
                'en' => 'Comfort & Design',
                'text' => '使用済みの保護カバーや機械パーツを回収し、再生素材として再利用。廃棄物削減に貢献します。'
            ],
        ],
    ],
    [
        'head' => 'コンビニエンスストア',
        'intro' => '緑川化成グループは、コンビニ向けに店内什器や保冷ケース部材などの樹脂製品を提供。デザイン性・清掃性・耐久性に優れた素材を用い、加工から施工まで一貫対応し、衛生的で快適な店舗づくりを支援します。',
        'processing_type' => 'facility_convenience',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '店舗のニーズに応じて、食品衛生法に準拠した安全な樹脂素材や、抗菌・防曇性に優れたアクリル・PET材などを提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '什器や陳列棚の透明パネル、冷蔵ケースの扉部材などを、切削・曲げ・接着・印刷といった多彩な加工技術で形にします。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => 'レジ前パーテーション、POP什器、商品ケース、照明カバー、冷蔵庫カバーなど、あらゆる店舗設備に対応可能です。'
            ],
            [
                'head' => '衛生性と<br class="hp_noneSp">メンテナンス性',
                'en' => 'Hygiene & Maintenance',
                'text' => '抗菌性素材の活用や清掃性を考慮した設計。'
            ],
        ],
    ],
    [
        'head' => 'レストラン',
        'intro' => '緑川化成グループは、レストラン向けに什器や間仕切り、メニューサインなどの樹脂製品を提供。安全性・清掃性に加え、意匠性や素材選定にもこだわり、快適で魅力的な店舗空間づくりをサポートします。',
        'processing_type' => 'facility_restaurant',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '耐熱・耐薬品性に加え、抗菌性や高意匠性に優れたアクリルやポリカーボネートなどを用途に応じて提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => 'パーテーションやメニュースタンドなどを切削・曲げ・接着・印刷などの加工により高品質に仕上げます。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '厨房パネル、店内仕切り、メニュー表示板、カウンター装飾、照明パネル、サーバー機器カバーなどに対応可能です。'
            ],
            [
                'head' => 'デザイン性と<br class="hp_noneSp">演出性',
                'en' => 'Design & Presentation',
                'text' => '光の透過や素材の質感を活かした製品設計。'
            ],
        ],
    ],
    [
        'head' => 'コスメショップ',
        'intro' => 'トレンド感と高級感が求められるコスメショップでは、洗練された空間演出が不可欠です。緑川化成グループは、化粧品什器・陳列棚・ミラー・POPツールなどに適した高意匠性の樹脂素材と加工技術を活かし、ブランドの世界観を空間で表現するサポートを行います。',
        'processing_type' => 'facility_cosmetics',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '高透明アクリルや光拡散性樹脂、耐擦傷性・意匠性に優れた特殊素材など、化粧品売場に適した素材をご提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '什器・ディスプレイ・装飾パーツなどを、切削・曲げ・接着・シルク印刷など多彩な加工技術で高品質に製造。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => 'スキンケア棚、メイクアップディスプレイ、POP・ネームプレート、試供品カウンター、プロモーション什器などに対応。'
            ],
            [
                'head' => 'ブランド演出力',
                'en' => 'Brand Experience',
                'text' => '素材感・光の演出・カラー設計を通じて、ブランドイメージを際立たせる空間提案を可能にし、購買意欲を高めます。'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>