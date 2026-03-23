<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_FACTORY;
$head_contents = [
    'head' => '工場',
    'en' => 'Factory',
    'intro' => '効率と環境への配慮を兼ね備えた<br class="hp_nonePc">現場づくりを実現。',
    'text' => '工場内の製造ラインや産業機械、包装資材、食品パッケージなどには多様な樹脂が使われており、製品そのものの樹脂化も進んでいます。緑川グループは、こうした現場に高機能樹脂部材を提供するとともに、回収・再生による循環型ものづくりで環境と生産性の両立を支えています。'
];

$items = [
    [
        'head' => '産業機械/<br>ライン・プラント',
        'intro' => '産業機械分野では、安全カバーや摺動部品、銘板など多様な樹脂部品が求められます。緑川グループは、機能性と加工性に優れた素材を選定し、再生可能な材料も活用しながら、お客様のご要望に沿った製品開発とリサイクル対応を両立しています。',
        'processing_type' => 'factory_machine',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '耐薬品性・耐摩耗性・滑り特性など、用途に合わせた樹脂素材を提案。再生樹脂にも対応します。'
            ],
            [
                'head' => '対応範囲',
                'en' => 'Coverage',
                'text' => '表示部・摺動部品・ギア類などに幅広く対応。小ロットの試作から量産まで柔軟に対応可能です。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '設備の安全性向上、メンテナンス性の確保、省人化や機械稼働の最適化をサポートします。'
            ],
            [
                'head' => '回収・リサイクル<br class="hp_noneSp">の仕組み',
                'en' => 'Material Proposal',
                'text' => '使用済みの保護カバーや機械パーツを回収し、再生素材として再利用。廃棄物削減に貢献します。'
            ],
        ],
    ],
    [
        'head' => '製品部品',
        'intro' => '映像設備まわりの樹脂部品に限らず、さまざまな製造現場で使用される製品パーツの供給にも対応しています。お客様の設計・仕様に合わせた素材選定から、加工、成形、組立までワンストップで対応可能です。',
        'processing_type' => 'factory_parts',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '高耐久・高機能な樹脂素材を用途や環境に合わせてご提案。設計仕様に基づき、最適な材料選定をサポートします。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '切削・曲げ・接着・印刷など多彩な加工技術に対応。高精度かつ安定した製品品質を提供します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '映像・医療・食品など幅広い分野で採用。現場ごとの使用条件に合った製品設計・供給が可能です。'
            ],
            [
                'head' => '環境配慮の<br class="hp_noneSp">取り組み',
                'en' => 'Material Proposal',
                'text' => '再生樹脂やリサイクル材を活用し、廃材削減やCO₂低減に貢献。持続可能な生産活動を支えます。'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>