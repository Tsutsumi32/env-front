/************************************************************
 * 全画面共通初期化処理
 * - 全ページで共通して実行される処理
 ************************************************************/

import { header } from '../modules/header.js';
import { themeToggle } from '../modules/themeToggle.js';
import { smoothAnchorLink } from '../utils/smoothAnchorLink.js';
import { initializeThemeSystem, watchSystemThemeChange } from '../utils/themeSystemInit.js';

/**
 * 全画面共通初期化処理
 * @param {Object} ctx - リソース（新旧両対応）
 * @param {Object} [ctx.scope] - 新: createPage から渡されるスコープ
 * @param {Object} [ctx.signal] - 旧: AbortSignal
 */
export async function initCommon(ctx) {
  const scope = ctx.scope ?? { signal: ctx.signal };
  const signal = scope.signal;

  // テーマ: 初期値の適用（localStorage or OS設定）
  initializeThemeSystem();
  // テーマ: 切替ボタン、OS変更の監視
  themeToggle.init({ scope });
  // テーマ: OS変更の監視
  watchSystemThemeChange(signal);

  // アンカーリンク
  smoothAnchorLink(signal);

  // ヘッダー（メニュー開閉・ESC・フォーカス管理）
  header.init({ scope });

  // JS 有効時用クラス削除
  document.body.classList.remove('is_nojs');

  // img保存策
  document.querySelectorAll('img').forEach((img) => {
    img.addEventListener(
      'contextmenu',
      (e) => e.preventDefault(),
      { signal }
    );
    img.addEventListener('selectstart', (e) => e.preventDefault(), { signal });
    img.addEventListener('mousedown', (e) => e.preventDefault(), { signal });
  });

  // main要素の最小高さを設定（画面の高さ - footerの高さ）
  const main = document.querySelector('main');
  const footer = document.querySelector('footer');

  if (main && footer) {
    const setMainMinHeight = () => {
      const viewportHeight = window.innerHeight;
      const footerHeight = footer.offsetHeight;
      main.style.minHeight = `${viewportHeight - footerHeight}px`;
    };
    setMainMinHeight();
    window.addEventListener('resize', setMainMinHeight, { signal });
  }
}
