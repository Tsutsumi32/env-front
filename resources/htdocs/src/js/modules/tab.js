/************************************************************
 * タブ
 * - [data-module="tab"] がルート。data-action="tab.select" でトリガー、[data-tab] で対象コンテンツ指定
 * - [data-tab-trigger] [data-tab-content] [data-tab] は参照用。アクティブは is_active（CSS で表示・フェード）
 ************************************************************/

import { DATA_ATTR, STATE_CLASSES } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';

// -----------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR は global.js）
// -----------------------------------------------------------------
const MODULE_TAB = 'tab';
const ATTR_TAB_TRIGGER = 'data-tab-trigger';
const ATTR_TAB_CONTENT = 'data-tab-content';
const ATTR_TAB = 'data-tab';

const SELECTOR_ROOT = `[${DATA_ATTR.MODULE}="${MODULE_TAB}"]`;
const SELECTOR_TRIGGER = `[${ATTR_TAB_TRIGGER}]`;
const SELECTOR_CONTENT = `[${ATTR_TAB_CONTENT}]`;

/**
 * 1 つのタブグループを初期化（ルートに delegate、data-action="tab.select"）
 * @param {Element} root
 * @param {{ signal: AbortSignal } | undefined} [scope] - 省略時は MPA 想定
 */
const initTabGroup = (root, scope) => {
  const triggers = root.querySelectorAll(SELECTOR_TRIGGER);
  const contents = root.querySelectorAll(SELECTOR_CONTENT);
  if (!triggers.length || !contents.length) return;

  delegate(root, 'click', {
    'tab.select': (e, el) => {
      e.preventDefault();
      const targetTab = el.getAttribute(ATTR_TAB);
      if (!targetTab || el.classList.contains(STATE_CLASSES.ACTIVE)) return;

      const newContent = root.querySelector(
        `${SELECTOR_CONTENT}[${ATTR_TAB}="${targetTab}"]`
      );
      if (!newContent) return;

      const currentContent = root.querySelector(
        `${SELECTOR_CONTENT}.${STATE_CLASSES.ACTIVE}`
      );
      if (currentContent) currentContent.classList.remove(STATE_CLASSES.ACTIVE);
      newContent.classList.add(STATE_CLASSES.ACTIVE);

      triggers.forEach((t) => t.classList.remove(STATE_CLASSES.ACTIVE));
      el.classList.add(STATE_CLASSES.ACTIVE);
    },
  }, scope);

  // 初期状態：最初のタブをアクティブに
  const firstTab = triggers[0];
  const firstTarget = firstTab.getAttribute(ATTR_TAB);
  if (firstTarget) {
    firstTab.classList.add(STATE_CLASSES.ACTIVE);
    const firstContent = root.querySelector(
      `${SELECTOR_CONTENT}[${ATTR_TAB}="${firstTarget}"]`
    );
    if (firstContent) firstContent.classList.add(STATE_CLASSES.ACTIVE);
  }
};

/**
 * 初期化
 * @param {{ scope?: { signal: AbortSignal }, root?: Element }} [ctx] - scope 省略時は MPA 想定
 */
const init = (ctx = {}) => {
  const { scope, root = document } = ctx;
  const roots = root.querySelectorAll(SELECTOR_ROOT);
  roots.forEach((r) => initTabGroup(r, scope));
};

export const tab = { init };
