/************************************************************
 * MPA の起動入口
 * - DOM 構築後に 共通処理(initCommon) を1回実行 → ページの start を実行し、cleanup を確保
 * - pagehide でページのクリーンアップを実行（共通処理はドキュメント寿命のため破棄しない）
 ************************************************************/

import { domReady } from './domReady.js';
import { initCommon } from '../common/initCommon.js';

/**
 * ページの start 関数を DOM 準備後に実行する
 * @param {(ctx: Object) => (() => void) | void} startPage - ページの start 関数（cleanup を返す）
 * @param {Object} [ctx={}] - 初期コンテキスト
 * @returns {Promise<() => void>} cleanup 関数（ページ固有のみ。共通は破棄しない）
 */
export const bootPage = async (startPage, ctx = {}) => {
  await domReady();

  // 全画面共通（1ドキュメントにつき1回。ページ毎の破棄はしない）
  await initCommon();

  const cleanup = startPage({ ...ctx, document, window }) || (() => {});
  window.addEventListener('pagehide', () => cleanup(), { once: true });
  return cleanup;
};
