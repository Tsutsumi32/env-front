<?php
if (!defined('ABSPATH')) exit;

$current_page_slug = Page::PRODUCTION_AMUSEMENT;
$head_contents = [
    'head' => 'アミューズメント',
    'en' => 'Amusement',
    'intro' => '快適さと演出性を両立した<br class="hp_nonePc">空間づくりを実現。',
    'text' => 'アーケード機器やアトラクションに使用される樹脂部材に対し、高い意匠性・透明性・加工性を備えた素材と製品を提供。多様なデザインニーズにも柔軟に対応し、魅力ある空間演出を支えます。'
];

$items = [
    [
        'head' => 'アーケードゲーム機',
        'intro' => 'エンターテインメント空間に欠かせないアーケードゲーム機では、意匠性・耐久性・加工精度を兼ね備えた部材が求められます。緑川化成グループは、筐体パネル・操作部カバー・イルミネーション部品など、多彩な用途に対応した素材と加工技術を提供します。',
        'processing_type' => 'amusement_arcade',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '耐衝撃性・透明性・加飾適性に優れたアクリルやポリカーボネートをはじめ、光の演出や高意匠を可能にする多彩な素材をご提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '曲げ加工・射出成形・印刷・真空成形など、多様な製造技術でニーズに応えます。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => 'ゲームセンターやアミューズメント施設に設置される筐体の外装パネル、透明操作部、照明カバー、スピーカーパネルなどに採用されています。'
            ],
            [
                'head' => 'デザイン対応力',
                'en' => 'Design Flexibility',
                'text' => '視覚的インパクトのあるカラー・光沢・加飾処理への対応に加え、設計段階からのサポートにより、ブランドイメージに合った製品開発を実現します。'
            ],
        ],
    ],
    [
        'head' => 'パチンコ',
        'intro' => '遊技機に求められるのは、圧倒的な意匠性と高い耐久性。緑川化成グループでは、筐体パネル・イルミネーションカバー・サウンド部品など、細部までこだわり抜いた素材と加工技術で、演出効果と信頼性を両立した製品を提供します。',
        'processing_type' => 'amusement_pachinko',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '演出力と加工性を両立する材料を選定・提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '射出成形・真空成形・印刷・接着など多彩な技術で実現します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => 'パチンコ機・パチスロ機の外装カバー、透明ディスプレイ部、などに幅広く活用されています。'
            ],
            [
                'head' => '表現力対応',
                'en' => 'Visual Impact Design',
                'text' => '視認性・演出性を高める意匠加工や、光透過性と印刷を組み合わせた加飾処理で、遊技者の体験を最大化。'
            ],
        ],
    ],
    [
        'head' => 'アトラクション',
        'intro' => 'テーマパークや遊園地に設置されるアトラクションでは、安全性はもちろん、来場者の印象に残るビジュアル表現が重要です。空間演出と安心を支える樹脂ソリューションを実現します。',
        'processing_type' => 'amusement_attraction',
        'lists' => [
            [
                'head' => '素材提案',
                'en' => 'Material Proposal',
                'text' => '屋外環境でも美しさと強度を保つ最適な素材を提案します。'
            ],
            [
                'head' => '製造技術',
                'en' => 'Manufacturing Technology',
                'text' => '大型サイズや曲面形状への対応、視覚演出を高める印刷・加飾成形、構造強化のための溶着・接着など、用途に応じた技術で対応します。'
            ],
            [
                'head' => '利用シーン',
                'en' => 'Usage Scenes',
                'text' => '屋外アトラクションの装飾パネル、ライドの安全カバー、フォトスポットの演出部材、照明演出用カバーなどに広く採用されています。'
            ],
            [
                'head' => '演出対応',
                'en' => 'Visual Presentation',
                'text' => 'デザイナーのアイデアを具現化し、エンターテインメント性を高める部材をご提供します。'
            ],
        ],
    ],
];

get_header();
?>
<?php require_once(get_theme_file_path('/inc/components/page-production-template.php')); ?>
<?php get_footer(); ?>