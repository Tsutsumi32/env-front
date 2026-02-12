/************************************************************
 * スクロールヒント（CDN 想定）
 * - data-feature="scrollHint" が対象。ScrollHint ライブラリでアイコン表示など
 ************************************************************/

import { DATA_ATTR } from '../constans/global.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR.FEATURE は global.js）
// ---------------------------------------------------------------------------
/** 機能名（data-feature の値）。data 属性の値はキャメルケース */
const FEATURE_NAME = 'scrollHint';

const SELECTOR_SCROLL_HINT = `[${DATA_ATTR.FEATURE}="${FEATURE_NAME}"]`;

/**
 * 初期化（ScrollHint がグローバルに存在する場合のみ）
 * @param {{ scope: { signal: AbortSignal } }} ctx
 * @param {{ target?: string, i18n?: object, remainingTime?: number, suggestiveShadow?: boolean, scrollHintIconAppendClass?: string }} [options]
 */
const init = ({ scope }, options = {}) => {
  const ScrollHint = window.ScrollHint;
  if (!ScrollHint) return;

  const target = options.target ?? SELECTOR_SCROLL_HINT;
  const instance = new ScrollHint(target, {
    i18n: options.i18n ?? { scrollable: 'scroll' },
    remainingTime: options.remainingTime ?? 5000,
    suggestiveShadow: options.suggestiveShadow ?? true,
    scrollHintIconAppendClass: options.scrollHintIconAppendClass ?? 'scroll-hint-icon-white',
  });

  if (typeof instance?.destroy === 'function') {
    scope.signal.addEventListener('abort', () => instance.destroy(), { once: true });
  }
};

export const scrollHint = { init };
