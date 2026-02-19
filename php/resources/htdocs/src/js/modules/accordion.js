/************************************************************
 * アコーディオン
 * - [data-module="accordion"] がルート。開閉状態はルートにのみ is_active で制御（CSS で表示切替）
 ************************************************************/

import { DATA_ATTR, STATE_CLASSES } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR は global.js）
// ---------------------------------------------------------------------------
const MODULE_ACCORDION = 'accordion';

const SELECTOR_ROOT = `[${DATA_ATTR.MODULE}="${MODULE_ACCORDION}"]`;

/**
 * 初期化（各アコーディオンルートにクリック委譲。data-action="accordion.toggle" をトリガーに）
 * @param {{ scope?: { signal: AbortSignal }, root?: Element }} [ctx] - scope 省略時は MPA 想定
 */
const init = (ctx = {}) => {
  const { scope, root = document } = ctx;
  const roots = root.querySelectorAll(SELECTOR_ROOT);
  roots.forEach((accordionRoot) => {
    delegate(accordionRoot, 'click', {
      'accordion.toggle': (e, el) => {
        if (e.target.closest('a')) return;
        accordionRoot.classList.toggle(STATE_CLASSES.ACTIVE);
      },
    }, scope);
  });
};

export const accordion = { init };
