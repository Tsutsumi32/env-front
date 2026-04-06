/************************************************************
 * モーダル拡張（プロジェクト用）
 * - modules/modal.js は編集せず、このファイルでプロジェクト固有の挙動を追加する
 * - 利用するページでは modules/modal の代わりに modules/extensions/modal を import する
 ************************************************************/

import { modal as coreModal } from '../modal.js';
import { delegate } from '../../utils/delegate.js';

// ----------------------------------------------------------
// プロジェクト固有の処理（必要に応じて実装）
// ----------------------------------------------------------

/**
 * モーダルを開いた直後に実行する処理（例: アナリティクス、内部要素の初期化）
 * @param {Element} [trigger] - 開くトリガーになった要素
 * @param {string} [id] - data-modal-id の値
 */
const onAfterOpen = (trigger, id) => {
  // 例: 特定モーダルIDごとの処理
  // if (id === 'contact') { ... }
  // 例: アナリティクス送信
  // sendEvent('modal_opened', { id });
};

/**
 * モーダルを閉じた直後に実行する処理
 */
const onAfterClose = () => {
  // 例: 閉じた後のフォームリセットなど
};

// ----------------------------------------------------------
// 拡張版 init（コア init の後に同じ data-action で追加登録 → 両方実行される）
// ----------------------------------------------------------

/**
 * モーダル初期化（コア + プロジェクト固有）
 * @param {{ scope?: { signal: AbortSignal } }} [ctx] - scope 省略時は MPA 想定
 */
const init = (ctx = {}) => {
  const { scope } = ctx;

  coreModal.init(ctx ?? {});

  delegate(document, 'click', {
    'modal.open': (e, el) => {
      const id = el?.getAttribute?.('data-modal-id') ?? undefined;
      onAfterOpen(el, id);
    },
    'modal.close': () => {
      onAfterClose();
    },
  }, scope);
};

export const modal = {
  open: coreModal.open,
  close: coreModal.close,
  init,
};
