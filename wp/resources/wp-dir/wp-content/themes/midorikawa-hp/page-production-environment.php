<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_ENVIRONMENT;
$head_contents = [
    'head' => '環境',
    'en' => ' Environment',
    'intro' => '資源を活かし、未来へつなぐ技術を。',
    'text' => '緑川グループは、再生素材の活用や廃材の回収・再資源化などを通じて、環境負荷の低減に取り組んでいます。社会の持続可能性を支えるものづくりを、素材と技術の両面から実現します。'
];

$items = [
    [
        'head' => '再生材料',
        'intro' => '限りある資源を無駄にしないものづくりを。緑川化成工業は、アクリルをはじめとする再生素材の提案・製品化を通じて、循環型社会の実現に貢献しています。回収から再資源化、再製品化までを視野に入れた開発体制で、持続可能なものづくりを支えます。',
        'processing_type' => 'environment_regeneration',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '廃材由来のリサイクルアクリルや再生ポリカーボネートなど、機能性と環境性能を両立する素材を提案。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '再生素材に適した成形・切削・加飾技術を保有。高品質な製品化を実現し、リサイクル材でも安定した性能を提供。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => 'サイン・什器・自動車部品・建材など、多様な分野で採用。'
            ],
            [
                'head' => '資源循環<br class="hp_noneSp">の仕組み',
                'en' => 'Circular Process',
                'text' => '使用済み製品の回収から素材の再生、製品化までを一貫して構築。'
            ],
        ],
    ],
    [
        'head' => '省エネルギー',
        'intro' => '限りあるエネルギー資源を有効に活用するため、緑川化成工業では省エネルギー性能に優れた樹脂素材や製品の開発を推進しています。',
        'processing_type' => 'environment_energy',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '遮熱・断熱性に優れたアクリルやポリカーボネート、光制御シートなど、省エネ効果の高い素材をニーズに合わせてご提案。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '熱加工や精密加工技術を用い、エネルギーロスを抑えた製品製造を実現。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '商業施設・住宅・工場などの建築用途から、自動車・機器類の部品まで、省エネ設計に貢献する部材を幅広く採用。'
            ],
            [
                'head' => 'エネルギー効率<br class="hp_noneSp">の追求',
                'en' => 'Energy Efficiency',
                'text' => '軽量・高断熱・高透過性を活かした省エネ提案。'
            ],
        ],
    ],
    [
        'head' => '回収リサイクル',
        'intro' => '緑川化成グループは、製品の提供にとどまらず、使用済みプラスチック製品の回収・再資源化にも取り組んでいます。回収した廃材は独自技術により高品質な素材へと再生され、再び新たな製品として活用されます。',
        'processing_type' => 'environment_recycle',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '再生可能なアクリルやポリカーボネートなど、リサイクル性に優れた素材を用途に応じて選定。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '真空成形・射出成形などに加え、再生原料の特性に合わせた最適な成形技術で、高品質な再生製品を安定供給します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '店舗什器、内装パネル、公共設備、工場資材など、リサイクル素材を活用した製品を多様な分野で展開しています。'
            ],
            [
                'head' => '資源循環<br class="hp_noneSp">の仕組み',
                'en' => 'Material Proposal',
                'text' => '「使用→回収→再生→再製品化」というクローズド・リサイクルの循環モデルを確立。'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>