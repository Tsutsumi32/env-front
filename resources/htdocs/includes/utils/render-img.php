<?php
function render_img(array $pcAttributes, array $spAttributes = []): void
{
    // ===== 関数内定数（スコープ限定） =====
    $BREAKPOINT_SP = 767;

    $IMAGE_BASE_PATH = $_SERVER['DOCUMENT_ROOT'] . '/resource/images';
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
<source srcset="{$spPaths['compression']}" media="(max-width: {$BREAKPOINT_SP}px)"{$spDims}>
HTML;
    }

    // ===== PC <source> =====
    echo <<<HTML
<source srcset="{$pcPaths['avif']}" type="image/avif"{$pcDims}>
<source srcset="{$pcPaths['webp']}" type="image/webp"{$pcDims}>
<source srcset="{$pcPaths['compression']}"{$pcDims}>
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
