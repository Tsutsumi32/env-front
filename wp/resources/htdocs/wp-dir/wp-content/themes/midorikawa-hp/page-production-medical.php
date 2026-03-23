<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_MEDICAL;
$head_contents = [
    'head' => '医療',
    'en' => 'Medical',
    'intro' => '安全性と清潔性を両立する医療現場を、<br class="hp_nonePc">高機能樹脂で支援。',
    'text' => '医療機器や診療設備、検査装置、薬品保管容器などには、高い衛生基準と耐薬品性が求められます。緑川グループは、医療現場に適した機能性樹脂素材と加工技術を通じて、安全で快適な医療環境づくりに貢献しています。また、回収・再資源化にも取り組み、医療分野における持続可能なものづくりを実現します。'
];

$items = [
    [
        'head' => '医療機器',
        'intro' => '医療機器の筐体や診療補助パーツ、保管用コンテナなど、幅広い用途に対応可能です。設計要件に応じた素材選定から、加工・成形・組立まで、緑川グループがワンストップでサポートし、安全性と品質の両立を実現します。',
        'processing_type' => 'medical_equipment',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '耐薬品性・耐熱性・清浄度など、医療現場で求められる特性に応じた樹脂素材をご提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => 'クリーン環境対応の加工・成形や精密な組立技術により、医療現場で求められる衛生性・信頼性に優れた部品を製造します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '検査機器・診療設備・保管容器・透析装置など、さまざまな医療現場での使用に対応しています。'
            ],
            [
                'head' => '品質・衛生<br class="hp_noneSp">管理体制',
                'en' => 'Quality & Hygiene Control',
                'text' => '医療衛生基準に対応した品質管理体制を整え、安全・安心の製品供給を実現します。'
            ],
        ],
    ],
    [
        'head' => '医療品容器',
        'intro' => '医薬品や検体を安全に保管・運搬するための樹脂製容器を、設計段階からご要望に応じて提案・供給します。厳格な衛生基準に対応し、医療現場での信頼性を支える製品づくりを行っています。',
        'processing_type' => 'medical_container',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '耐薬品性・透明性・滅菌対応など、医療用途に適した樹脂素材を用途に応じてご提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '成形・接着・印刷・検査などの工程を一貫して対応し、高精度かつ安全性の高い製品を提供します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '薬液容器・検体容器・滅菌容器など、病院・研究施設・製薬工場における多様なニーズに対応します。'
            ],
            [
                'head' => '衛生対応の体制',
                'en' => 'Hygiene Compliance',
                'text' => 'クリーンルームでの製造や、医療衛生基準に基づいた品質管理体制を整備。高い信頼性と安全性を実現します。'
            ],
        ],
    ],
    [
        'head' => '衛生用品',
        'intro' => '病院・介護・家庭などで使われる衛生用品において、抗菌性や安全性、使い勝手の良さが求められます。緑川グループでは、設計・素材選定から加工・成形まで対応し、清潔さと機能性を両立した製品を提供します。',
        'processing_type' => 'medical_sanitary',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '抗菌・防カビ・柔軟性など、用途に適した機能性樹脂を選定し、製品の安全性・快適性を高めます。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '成形・接着・フィルム加工など、多様な加工に対応し、使いやすく衛生的な製品を安定供給します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '医療・介護・家庭など、手袋・マスク・容器・ディスペンサーなど様々な衛生用品に対応可能です。'
            ],
            [
                'head' => '安全性への配慮',
                'en' => 'Safety Assurance',
                'text' => '建設現場で使用されるキャノピーパネルやダクトを、リサイクル可能な樹脂素材で製造'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>