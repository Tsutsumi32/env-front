/************************************************************
 * MPA の起動入口
 * - DOM 構築後に start を実行し、cleanup を確保
 * - pagehide でクリーンアップを実行（MPAでも一貫性のために実施）
 ************************************************************/

import { domReady } from './domReady.js';

/**
 * ページの start 関数を DOM 準備後に実行する
 * @param {(ctx: Object) => (() => void) | void} startPage - ページの start 関数（cleanup を返す）
 * @param {Object} [ctx={}] - 初期コンテキスト
 * @returns {Promise<() => void>} cleanup 関数
 */
export const bootPage = async (startPage, ctx = {}) => {
  await domReady();
  const cleanup = startPage({ ...ctx, document, window }) || (() => {});
  window.addEventListener('pagehide', () => cleanup(), { once: true });
  return cleanup;
};
