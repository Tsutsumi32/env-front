<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_VEHICLE;
$head_contents = [
    'head' => '乗り物',
    'en' => 'Vehicle',
    'intro' => '緑川グループの技術で、<br>モビリティ業界の循環型ものづくりを実現。',
    'text' => '緑川グループは、自動車、鉄道、航空など乗り物に関する幅広い分野で高機能な樹脂製品を提供するとともに、使用後の製品を回収し、再生素材として活用する「循環型ものづくり」 に取り組んでいます。軽量化や耐久性の向上だけでなく、リサイクルによる環境負荷の低減も追求し、持続可能なモビリティの未来を支えます。'
];

$items = [
    [
        'head' => '自動車/二輪車',
        'processing_type' => 'vehicle_car',
        'intro' => '自動車用品の多様なニーズに対応するため、リサイクル可能な樹脂素材を活用し、使用後の回収・再資源化を考慮した提案を行っています。<br>板材からペレットまで、最適な素材・加工方法を選定し、持続可能なものづくりを実現します。',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '高透明性や耐候性を持つアクリルやポリカーボネートを使用。用途に応じた最適な素材を提案します。'
            ],
            [
                'head' => '対応範囲',
                'en' => 'Coverage',
                'text' => '小ロット品は真空成形、大ロット品は射出成形を採用。フィルムを用いた木目調加飾にも対応。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '車両の軽量化や耐久性向上だけでなく、使用後の部品回収システムも構築。'
            ],
            [
                'head' => '回収・リサイクル<br class="hp_noneSp">の仕組み',
                'en' => 'Material Proposal',
                'text' => '使用後の内装部品やパネルを回収し、再生アクリル板や新素材へ'
            ],
        ],
    ],
    [
        'head' => '鉄道/バス',
        'processing_type' => 'vehicle_train',
        'intro' => '生活の脚となる公共交通機関では、環境負荷の低減と人々の安全を守る事が必須テーマとなります。当社ではオリジナル素材、製品加工技術を駆使しそれらに貢献しています。',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '環境配慮型の再生アクリル板「リアライト」を使用し、CO2排出量削減を実現。省電力LED光源も活用。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '耐久性を重視した印刷やフィルム加工技術を駆使し、長時間の使用に耐える製品を提供。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '駅やバス停での公共案内設備や安全装置に採用。'
            ],
            [
                'head' => '再資源化の<br class="hp_noneSp">取り組み',
                'en' => 'Material Proposal',
                'text' => '鉄道やバスのサインディスプレイや駅案内板を回収し、再生素材へ'
            ],
        ],
    ],
    [
        'head' => '建機',
        'processing_type' => 'vehicle_machine',
        'intro' => '建設機械は設計の自由度が上がる樹脂化を推し進めています。 形状や用途・ロットに応じて、最適な素材と加工方法のご提案を致します。',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '透明性と耐候性に優れた素材を使用したキャノピ用プレートや、耐熱性と耐衝撃性を兼ね備えたダクト用素材を採用。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '射出成形や真空成形を駆使し、高い精度と耐久性を実現。さらに、特定用途に応じたカスタム加工で幅広いニーズに対応可能。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '建機のキャノピ部の視認性確保や、エンジン周りのダクトとして採用され、作業の快適性と機械の効率性を支えます。'
            ],
            [
                'head' => 'サステナブルな<br class="hp_noneSp">資材提供',
                'en' => 'Material Proposal',
                'text' => '建設現場で使用されるキャノピーパネルやダクトを、リサイクル可能な樹脂素材で製造'
            ],
        ],
    ],
    [
        'head' => '航空機',
        'processing_type' => 'vehicle_aircraft',
        'intro' => '航空機には安全性と軽量化の両方が求められています。ご要望に合わせた最適な素材と加工方法を提案致します。',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '軽量かつ耐衝撃性に優れたプラスチックを使用。安全基準を満たした素材を提供。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '射出成形や高精度な切削加工を活用し、航空機独自のニーズに対応。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '機内の内装部品や保温カートとして採用され、快適性と機能性を支えます。'
            ],
            [
                'head' => 'リサイクル<br class="hp_noneSp">ソリューション',
                'en' => 'Material Proposal',
                'text' => 'ウィンドウカバーや内装パネルを再生素材として活用'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>