/************************************************************
 * モーダル（1ファイルに集約・js-fix 方針）
 * - data-action="modal.open" / "modal.close" で document に delegate（open トリガーが散らばるため）
 * - data-module="modal" がモーダルルート、data-modal-id で複数モーダルを識別
 * - open/close、背景クリック・ESC、スクロール制御・アコーディオン後片付けまでここで実施
 ************************************************************/

import { STATE_CLASSES } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';
import { fadeIn, fadeOut } from '../utils/fadeAnimation.js';
import { disableScroll, enableScroll } from '../utils/scrollControll.js';
import { slideUp } from '../utils/slideAnimation.js';

const ANIMATION_SPEED = 400;

/**
 * モーダルルート要素を取得（id があれば data-modal-id で一致するものを取得）
 * @param {string} [id] - data-modal-id の値
 * @returns {HTMLElement | null}
 */
const getModalRoot = (id) => {
  if (id) {
    const el = document.querySelector(`[data-module="modal"][data-modal-id="${id}"]`);
    if (el) return el;
  }
  return document.querySelector('[data-module="modal"]');
};

/**
 * 現在開いているモーダル要素を取得
 * @returns {HTMLElement | null}
 */
const getOpenModal = () => {
  return document.querySelector(`[data-module="modal"].${STATE_CLASSES.ACTIVE}`);
};

let isInitialized = false;

/**
 * ESC・背景クリックなど、1回だけ登録するリスナー
 */
const initOnce = () => {
  if (isInitialized) return;
  isInitialized = true;

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });

  document.addEventListener('click', (e) => {
    const modal = getOpenModal();
    if (!modal) return;
    if (e.target.hasAttribute('data-modal-overlay')) close();
  });
};

/**
 * モーダルを開く
 * @param {{ trigger?: Element, id?: string }} [payload] - data-modal-id は trigger の data-modal-id から渡る
 */
const open = (payload = {}) => {
  initOnce();
  const id = payload.id ?? payload.trigger?.dataset?.modalId;
  const root = getModalRoot(id);
  if (!root) return;

  root.classList.add(STATE_CLASSES.ACTIVE);
  root.hidden = false;
  root.style.display = 'block';
  root.style.opacity = '0';
  fadeIn(root, ANIMATION_SPEED, true, undefined);
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

  const scrollableElements = root.querySelectorAll('[data-modal-scroll]');

  if (scrollableElements.length > 0) {
    setTimeout(() => {
      scrollableElements.forEach((el) => {
        el.scrollTop = 0;
      });
    }, ANIMATION_SPEED);
  }

  fadeOut(root, ANIMATION_SPEED, true, undefined);
  root.classList.remove(STATE_CLASSES.ACTIVE);
  enableScroll(true);

  setTimeout(() => {
    root.hidden = true;
    root.style.display = '';

    const accordionParents = root.querySelectorAll(`[data-module="accordion"].${STATE_CLASSES.ACTIVE}`);
    accordionParents.forEach((parent) => {
      const contents = parent.querySelector('[data-accordion-contents]');
      if (contents) {
        slideUp(contents, 300, 'ease-out', undefined);
        parent.classList.remove(STATE_CLASSES.ACTIVE);
      }
    });

    const hiddenButtons = root.querySelectorAll('button[style*="display: none"]');
    hiddenButtons.forEach((btn) => {
      btn.style.display = '';
    });
  }, ANIMATION_SPEED);
};

/**
 * モーダルを初期化する（document に delegate して modal.open / modal.close を拾う）
 * @param {{ scope: { signal: AbortSignal } }} ctx - createPage の scope を渡す
 */
const init = ({ scope }) => {
  delegate(document, scope, {
    'modal.open': (e, el) => {
      open({ trigger: el, id: el.dataset.modalId });
    },
    'modal.close': () => {
      close();
    },
  });
};

export const modal = { open, close, init };
