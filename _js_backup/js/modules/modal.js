/************************************************************
 * モーダル（1ファイルに集約・js-fix 方針）
 * - data-action="modal.open" / "modal.close" で document に delegate（open トリガーが散らばるため）
 * - data-module="modal" がモーダルルート、data-modal-id で複数モーダルを識別
 * - open/close、背景クリック・ESC、スクロール制御、フォーカス管理（トラップ・復帰）
 ************************************************************/

import { DATA_ATTR, STATE_CLASSES } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';
import {
  handleFocusTrapKeydown,
  prepareAndFocusContainer,
  returnFocus,
} from '../utils/focusControl.js';
import { disableScroll, enableScroll } from '../utils/bodyScrollControll.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR は global.js）
// ---------------------------------------------------------------------------
const MODULE_MODAL = 'modal';
const ATTR_MODAL_ID = 'data-modal-id';
const ATTR_MODAL_DIALOG = 'data-modal-dialog';
const ATTR_MODAL_SCROLL = 'data-modal-scroll';

/** フェード時間（ms）。CSS の fade-initial の duration と揃える */
const FADE_DURATION_MS = 400;

/** 閉じたときにフォーカスを戻す要素（open を押したトリガー） */
let lastTrigger = null;

/**
 * モーダルルート要素を取得（id があれば data-modal-id で一致するものを取得）
 * @param {string} [id] - data-modal-id の値
 * @returns {HTMLElement | null}
 */
const getModalRoot = (id) => {
  if (id) {
    const el = document.querySelector(`[${DATA_ATTR.MODULE}="${MODULE_MODAL}"][${ATTR_MODAL_ID}="${id}"]`);
    if (el) return el;
  }
  return document.querySelector(`[${DATA_ATTR.MODULE}="${MODULE_MODAL}"]`);
};

/**
 * 現在開いているモーダル要素を取得
 * @returns {HTMLElement | null}
 */
const getOpenModal = () => {
  return document.querySelector(`[${DATA_ATTR.MODULE}="${MODULE_MODAL}"].${STATE_CLASSES.ACTIVE}`);
};

let isInitialized = false;

/**
 * ESC・背景クリック・Tab トラップなど、1回だけ登録するリスナー
 */
const initOnce = () => {
  if (isInitialized) return;
  isInitialized = true;

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      close();
      return;
    }
    if (e.key !== 'Tab') return;
    const modal = getOpenModal();
    if (modal) handleFocusTrapKeydown(modal, e);
  });
};

/**
 * モーダルを開く
 * @param {{ trigger?: Element, id?: string }} [payload] - data-modal-id は trigger の data-modal-id から渡る
 */
const open = (payload = {}) => {
  initOnce();
  const id = payload.id ?? payload.trigger?.getAttribute(ATTR_MODAL_ID);
  const root = getModalRoot(id);
  if (!root) return;

  lastTrigger = payload.trigger instanceof HTMLElement ? payload.trigger : document.activeElement;

  root.hidden = false;
  root.setAttribute('aria-hidden', 'false');
  // 初期状態（opacity: 0）を 1 フレーム描画してから is_active を付与し、フェードインの transition を走らせる
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      root.classList.add(STATE_CLASSES.ACTIVE);
      prepareAndFocusContainer(root, {
        trigger: lastTrigger,
        fallbackSelector: `[${ATTR_MODAL_DIALOG}]`,
      });
    });
  });
  disableScroll(true, undefined);
};

/**
 * モーダルを閉じる
 */
const close = () => {
  const root = getOpenModal();
  if (!root) {
    enableScroll(true);
    return;
  }

  const scrollableElements = root.querySelectorAll(`[${ATTR_MODAL_SCROLL}]`);
  if (scrollableElements.length > 0) {
    scrollableElements.forEach((el) => {
      el.scrollTop = 0;
    });
  }

  root.classList.remove(STATE_CLASSES.ACTIVE);
  enableScroll(true);

  let done = false;
  const triggerToReturn = lastTrigger;
  const onTransitionEnd = () => {
    if (done) return;
    done = true;
    root.removeEventListener('transitionend', onTransitionEnd);
    root.hidden = true;
    root.setAttribute('aria-hidden', 'true');
    returnFocus(triggerToReturn);
    lastTrigger = null;
  };

  root.addEventListener('transitionend', onTransitionEnd, { once: true });
  setTimeout(() => onTransitionEnd(), FADE_DURATION_MS + 50);
};

/**
 * モーダルを初期化する（document に delegate して modal.open / modal.close を拾う）
 * @param {{ scope?: { signal: AbortSignal } }} [ctx] - scope 省略時は MPA 想定
 */
const init = (ctx = {}) => {
  const { scope } = ctx ?? {};
  delegate(document, 'click', {
    'modal.open': (e, el) => {
      open({ trigger: el, id: el.getAttribute(ATTR_MODAL_ID) });
    },
    'modal.close': () => {
      close();
    },
  }, scope);
};

export const modal = { open, close, init };
