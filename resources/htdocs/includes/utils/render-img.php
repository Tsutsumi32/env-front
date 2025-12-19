<?php
/**
 * レスポンシブ画像を出力する関数
 *
 * PC用とSP用の画像を適切な形式（AVIF、WebP、圧縮版）で出力します。
 *
 * @param array $pcAttributes PC用画像の属性（必須: src）
 * @param array $spAttributes SP用画像の属性（オプション）
 *
 * 使用例1: PCのみの画像（width/height指定あり）
 * <?php
 * render_img([
 *     'src' => 'hero/main.jpg',
 *     'alt' => 'メイン画像',
 *     'width' => '1200',
 *     'height' => '600',
 *     'class' => 'hero-image'
 * ]);
 * ?>
 *
 * 出力結果1:
 * <source srcset="/assets/images/avif/hero/main.avif" type="image/avif" width="1200" height="600">
 * <source srcset="/assets/images/webp/hero/main.webp" type="image/webp" width="1200" height="600">
 * <img src="/assets/images/compression/hero/main.jpg" alt="メイン画像" width="1200" height="600" class="hero-image">
 *
 * 使用例2: PCとSPの両方の画像
 * <?php
 * render_img(
 *     [
 *         'src' => 'banner/pc-banner.jpg',
 *         'alt' => 'PC用バナー',
 *         'width' => '1200',
 *         'height' => '300'
 *     ],
 *     [
 *         'src' => 'banner/sp-banner.jpg',
 *         'alt' => 'SP用バナー',
 *         'width' => '750',
 *         'height' => '400'
 *     ]
 * );
 * ?>
 *
 * 出力結果2:
 * <source srcset="/assets/images/avif/banner/sp-banner.avif" type="image/avif" media="(max-width: 767px)" width="750" height="400">
 * <source srcset="/assets/images/webp/banner/sp-banner.webp" type="image/webp" media="(max-width: 767px)" width="750" height="400">
 * <source srcset="/assets/images/avif/banner/pc-banner.avif" type="image/avif" width="1200" height="300">
 * <source srcset="/assets/images/webp/banner/pc-banner.webp" type="image/webp" width="1200" height="300">
 * <img src="/assets/images/compression/banner/pc-banner.jpg" alt="PC用バナー" width="1200" height="300">
 *
 * 使用例3: シンプルな画像（width/heightなし）
 * <?php
 * render_img([
 *     'src' => 'logo.png',
 *     'alt' => 'ロゴ'
 * ]);
 * ?>
 *
 * 出力結果3:
 * <source srcset="/assets/images/avif/logo.avif" type="image/avif">
 * <source srcset="/assets/images/webp/logo.webp" type="image/webp">
 * <img src="/assets/images/compression/logo.png" alt="ロゴ">
 */
function render_img(array $pcAttributes, array $spAttributes = []): void
{
    // ===== 関数内定数（スコープ限定） =====
    $BREAKPOINT_SP = 767;

    $IMAGE_BASE_URI  = '/assets/images';
    $DIR_ORIGIN = '_origin';
    $DIR_WEBP   = 'webp';
    $DIR_AVIF   = 'avif';
    $DIR_COMPRESSION   = 'compression';

    // ===== パス構築 =====
    $buildPaths = function ($src) use (
        $IMAGE_BASE_URI,
        $DIR_ORIGIN,
        $DIR_WEBP,
        $DIR_AVIF,
        $DIR_COMPRESSION
    ) {
        $info = pathinfo($src);
        $dirname = $info['dirname'] !== '.' ? $info['dirname'] . '/' : '';
        $basename = $info['filename'];
        $ext = $info['extension'];

        return [
            'origin' => "{$IMAGE_BASE_URI}/{$DIR_ORIGIN}/{$dirname}{$basename}.{$ext}",
            'webp'   => "{$IMAGE_BASE_URI}/{$DIR_WEBP}/{$dirname}{$basename}.webp",
            'avif'   => "{$IMAGE_BASE_URI}/{$DIR_AVIF}/{$dirname}{$basename}.avif",
            'compression'   => "{$IMAGE_BASE_URI}/{$DIR_COMPRESSION}/{$dirname}{$basename}.{$ext}",
        ];
    };

    // ===== 必須チェック =====
    $pcSrc = $pcAttributes['src'] ?? '';
    if (!$pcSrc) {
        echo '<!-- src属性が必要です -->';
        return;
    }

    $pcPaths = $buildPaths($pcSrc);
    $spPaths = $spAttributes && !empty($spAttributes['src']) ? $buildPaths($spAttributes['src']) : null;

    // ===== width / height 抽出 =====
    $extractDimensions = function ($attrs) {
        $out = '';
        foreach (['width', 'height'] as $dim) {
            if (!empty($attrs[$dim])) {
                $out .= sprintf(' %s="%s"', $dim, htmlspecialchars($attrs[$dim]));
            }
        }
        return $out;
    };
    $pcDims = $extractDimensions($pcAttributes);
    $spDims = $extractDimensions($spAttributes);

    // ===== SP <source> =====
    if ($spPaths) {
        echo <<<HTML
<source srcset="{$spPaths['avif']}" type="image/avif" media="(max-width: {$BREAKPOINT_SP}px)"{$spDims}>
<source srcset="{$spPaths['webp']}" type="image/webp" media="(max-width: {$BREAKPOINT_SP}px)"{$spDims}>
HTML;
    }

    // ===== PC <source> =====
    echo <<<HTML
<source srcset="{$pcPaths['avif']}" type="image/avif"{$pcDims}>
<source srcset="{$pcPaths['webp']}" type="image/webp"{$pcDims}>
HTML;

    // ===== <img> タグ（PC attributes のみ） =====
    $imgAttrs = $pcAttributes;
    $imgAttrs['src'] = $pcPaths['compression'];
    unset($imgAttrs['srcset'], $imgAttrs['src']); // safety

    $attrStr = '';
    foreach ($imgAttrs as $k => $v) {
        $attrStr .= sprintf(' %s="%s"', htmlspecialchars($k), htmlspecialchars($v));
    }

    echo "<img src=\"{$pcPaths['compression']}\"{$attrStr}>";
}
