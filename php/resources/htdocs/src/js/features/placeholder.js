/************************************************************
 * ボタンセレクト（検索入力）プレースホルダー表示制御
 * - data-action="placeholder.sync" を input に付与
 * - data-feature-placeholder-input / data-feature-placeholder-placeholder で表示を入力有無で切替
 * - ルート外の input もあるため document に delegate（input / focus / blur）
 ************************************************************/

import { DATA_ATTR, STATE_CLASSES } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR.FEATURE は global.js）
// ---------------------------------------------------------------------------
/** 機能名（data-feature の値）。data 属性の値はキャメルケース */
const FEATURE_NAME = 'placeholder';

const ATTR_INPUT = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-input`;
const ATTR_PLACEHOLDER = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-placeholder`;

const SELECTOR_INPUT = `[${ATTR_INPUT}]`;
const SELECTOR_PLACEHOLDER = `[${ATTR_PLACEHOLDER}]`;

const syncPlaceholder = (e, el) => {
  const placeholderEl = el.parentElement?.querySelector(SELECTOR_PLACEHOLDER);
  if (!placeholderEl) return;
  if (el.value.trim() === '') placeholderEl.classList.remove(STATE_CLASSES.HIDDEN);
  else placeholderEl.classList.add(STATE_CLASSES.HIDDEN);
};

/**
 * 初期化（document に delegate。data-action="placeholder.sync" を input/focus/blur で）
 * @param {{ scope: { signal: AbortSignal } }} ctx
 */
const init = ({ scope }) => {
  delegate(document, scope, { 'placeholder.sync': syncPlaceholder }, { eventType: 'input' });
  delegate(document, scope, { 'placeholder.sync': syncPlaceholder }, { eventType: 'focus' });
  delegate(document, scope, { 'placeholder.sync': syncPlaceholder }, { eventType: 'blur' });

  document.querySelectorAll(`${SELECTOR_INPUT}[data-action="placeholder.sync"]`).forEach((input) => {
    const placeholderEl = input.parentElement?.querySelector(SELECTOR_PLACEHOLDER);
    if (placeholderEl) syncPlaceholder(null, input);
  });
};

export const placeholder = { init };
