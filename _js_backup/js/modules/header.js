/************************************************************
 * ヘッダー（メニュー開閉）
 * - [data-module="header"] がルート。開閉状態はルートにのみ is_active で制御（CSS で表示・アニメーション）
 * - data-action="header.toggle" メニューボタン、data-action="header.close" 背景・リンク
 * - [data-header-btn] [data-header-menu] [data-header-bg] は参照用
 * - ESC で閉じる、開いている間はフォーカスをメニュー内にトラップ（a11y）
 ************************************************************/

import { DATA_ATTR, STATE_CLASSES } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';
import { disableScroll, enableScroll } from '../utils/bodyScrollControll.js';
import {
  handleFocusTrapKeydown,
  prepareAndFocusContainer,
  returnFocus,
} from '../utils/focusControl.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR は global.js）
// ---------------------------------------------------------------------------
const MODULE_HEADER = 'header';
const ATTR_HEADER_BTN = 'data-header-btn';
const ATTR_HEADER_MENU = 'data-header-menu';
const ATTR_HEADER_BG = 'data-header-bg';

const SELECTOR_HEADER = `[${DATA_ATTR.MODULE}="${MODULE_HEADER}"]`;
const SELECTOR_BTN = `[${ATTR_HEADER_BTN}]`;
const SELECTOR_MENU = `[${ATTR_HEADER_MENU}]`;
const SELECTOR_BG = `[${ATTR_HEADER_BG}]`;

let lastFocusTrigger = null;

const getHeader = () => document.querySelector(SELECTOR_HEADER);

const isOpen = () => getHeader()?.classList.contains(STATE_CLASSES.ACTIVE) ?? false;

/**
 * メニューを開く
 */
const open = () => {
  const header = getHeader();
  if (!header) return;

  const menuBtn = header.querySelector(SELECTOR_BTN);
  const menu = header.querySelector(SELECTOR_MENU);
  const bg = header.querySelector(SELECTOR_BG);
  if (!menuBtn || !menu || !bg) return;

  lastFocusTrigger = document.activeElement instanceof HTMLElement ? document.activeElement : null;
  header.classList.add(STATE_CLASSES.ACTIVE);
  header.setAttribute('aria-expanded', 'true');
  disableScroll(true, undefined);
  prepareAndFocusContainer(header, { trigger: lastFocusTrigger, fallbackSelector: SELECTOR_MENU });
};

/**
 * メニューを閉じる
 */
const close = () => {
  const header = getHeader();
  if (!header) return;

  header.classList.remove(STATE_CLASSES.ACTIVE);
  header.setAttribute('aria-expanded', 'false');
  enableScroll(true);
  returnFocus(lastFocusTrigger);
  lastFocusTrigger = null;
};

/**
 * 初期化（ルートに delegate。data-action="header.toggle" / "header.close" で開閉。ESC・Tab は document）
 * @param {{ scope?: { signal: AbortSignal } }} [ctx] - scope 省略時は MPA 想定
 */
const init = (ctx = {}) => {
  const { scope } = ctx;
  const header = getHeader();
  if (!header) return;

  header.setAttribute('aria-expanded', 'false');

  delegate(header, 'click', {
    'header.toggle': () => {
      if (isOpen()) close();
      else open();
    },
    'header.close': close,
  }, scope);

  const keydownOptions = scope?.signal ? { signal: scope.signal } : {};
  document.addEventListener(
    'keydown',
    (e) => {
      if (e.key === 'Escape' && isOpen()) close();
      if (e.key === 'Tab' && isOpen()) handleFocusTrapKeydown(header, e);
    },
    keydownOptions
  );
};

export const header = { init, open, close };
