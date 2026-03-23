<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_AGRICULTURE;
$head_contents = [
    'head' => '農水産業',
    'en' => 'Forestry And Fisheries',
    'intro' => '自然と共生しながら<br class="hp_nonePc">効率的な生産を支える資材づくり。',
    'text' => 'ビニールハウスや養殖ネットなど、農業・水産業の生産現場では、耐候性・耐久性・衛生性の高い樹脂素材が求められています。緑川グループは、こうした現場ニーズに応える高機能素材と部材を提供するとともに、回収・再生による循環型の資材利用を推進し、持続可能な一次産業を支えています。'
];

$items = [
    [
        'head' => '農業資材',
        'intro' => 'ビニールハウス、育苗トレイ、農業用タンクなど、農業の現場では機能性と耐候性に優れた樹脂製品が活躍しています。緑川化成グループは、農作業の効率化や長期利用に貢献する資材を、現場のニーズに合わせて提供。環境変化に強く、持続可能な農業を支える素材と技術をご提案します。',
        'processing_type' => 'agriculture_agriculture',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => 'UV耐性・耐衝撃性・軽量性などを備えたポリカーボネートやポリエチレンなど、使用環境に最適な素材を選定しご提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '大型真空成形・押出成形・射出成形により、育苗容器からパネル・パーツまで多彩な製品を高精度に加工可能です。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => 'ビニールハウスの骨組みや屋根材、収穫用ケース、農機のパーツ、タンク・貯蔵容器など、様々な用途に対応します。'
            ],
            [
                'head' => '耐久性対応',
                'en' => 'Durability Optimization',
                'text' => '紫外線や風雨、薬剤散布などの過酷な条件下でも、長期使用を可能にする設計と素材を採用。'
            ],
        ],
    ],
    [
        'head' => '漁業資材',
        'intro' => '養殖ネット、浮き、魚箱、タンクなど、漁業・水産業の現場では、耐塩性・耐候性・衛生性を兼ね備えた樹脂製品が不可欠です。緑川化成グループは、現場の使用環境や目的に応じて、最適な素材と加工方法を提案。水産現場の効率化と安全性向上に貢献します。',
        'processing_type' => 'agriculture_aquaculture',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '海水や紫外線に強く、衛生管理がしやすいポリエチレン・ポリプロピレン・PVCなどの素材を用途に応じてご提案。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '大型成形・切削・溶着・組立まで幅広い技術を保有し、漁具・養殖資材・容器など多様な製品の製造が可能です。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '養殖用ネットフレーム、浮き、搬送コンテナ、仕分けトレイ、魚介類の一時保管容器などに対応。'
            ],
            [
                'head' => '耐海水対応',
                'en' => 'Marine Durability',
                'text' => '塩害や波の衝撃、紫外線に対して高い耐久性を発揮する素材を使用し、長期使用と低メンテナンスを両立。'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>