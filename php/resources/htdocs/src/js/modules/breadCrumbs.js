/************************************************************
 * パンくずリスト
 * - 横幅を調整する（1行に納め、末尾のリストを末尾省略）
 * - data-module="breadCrumbs" がコンテナ、[data-breadCrumbs-item] が各アイテム、[data-breadCrumbs-itemText] が末尾省略対象のテキスト要素
 ************************************************************/

import { DATA_ATTR } from '../constans/global.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR は global.js）
// ---------------------------------------------------------------------------
const MODULE_BREAD_CRUMBS = 'breadCrumbs';
const ATTR_BREADCRUMBS_ITEM = 'data-breadCrumbs-item';
/** 各アイテム内で省略表示を適用するテキスト要素（data 属性で参照） */
const ATTR_BREADCRUMBS_ITEM_TEXT = 'data-breadCrumbs-itemText';

const SELECTOR_BREADCRUMBS = `[${DATA_ATTR.MODULE}="${MODULE_BREAD_CRUMBS}"]`;
const SELECTOR_BREADCRUMBS_ITEM = `[${ATTR_BREADCRUMBS_ITEM}]`;
const SELECTOR_BREADCRUMBS_ITEM_TEXT = `[${ATTR_BREADCRUMBS_ITEM_TEXT}]`;

const DEFAULT_MARGIN_OFFSET = 16;

/**
 * 初期化
 * @param {{ scope: { signal: AbortSignal } }} ctx
 * @param {{ marginOffset?: number }} [options]
 */
const init = ({ scope }, options = {}) => {
  const container = document.querySelector(SELECTOR_BREADCRUMBS);
  if (!container) return;

  const items = container.querySelectorAll(SELECTOR_BREADCRUMBS_ITEM);
  if (!items.length) return;

  const marginOffset = options.marginOffset ?? DEFAULT_MARGIN_OFFSET;

  const adjustBreadWidth = () => {
    const containerWidth = container.getBoundingClientRect().width;
    let usedWidth = 0;

    items.forEach((item, index) => {
      if (index !== items.length - 1) {
        const rect = item.getBoundingClientRect();
        const style = window.getComputedStyle(item);
        usedWidth += rect.width + parseFloat(style.marginLeft) + parseFloat(style.marginRight);
      }
    });

    const remainingWidth = containerWidth - usedWidth;
    const lastItemWrapper = items[items.length - 1];
    const lastItemText = lastItemWrapper.querySelector(SELECTOR_BREADCRUMBS_ITEM_TEXT);

    if (lastItemText && remainingWidth > 0) {
      lastItemText.style.maxWidth = `${remainingWidth - marginOffset}px`;
      lastItemText.style.overflow = 'hidden';
      lastItemText.style.textOverflow = 'ellipsis';
      lastItemText.style.whiteSpace = 'nowrap';
    }
  };

  adjustBreadWidth();
  window.addEventListener('resize', adjustBreadWidth, { signal: scope.signal });
};

export const breadCrumbs = { init };
