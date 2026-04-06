/************************************************************
 * MPA の起動入口
 * ※メモ:abort等を使用してイベント破棄するライフサイクルは、MPAは一旦不要なため、複雑化を避けるためにも排除し、簡潔な構成とする
 * - DOM 構築後に共通処理(initCommon) を1回実行 → ページの start を実行
 ************************************************************/

import { domReady } from './domReady.js';
import { initCommon } from '../common/initCommon.js';

/**
 * ページの start 関数を DOM 準備後に実行する
 * @param {() => void} startPage
 */
export const bootPage = async (startPage) => {
  await domReady();

  await initCommon();

  startPage();
};
