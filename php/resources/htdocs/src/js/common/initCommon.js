/************************************************************
 * 全画面共通初期化処理
 * - 全ページで共通して実行される処理（ヘッダー・スムースアンカー・body クラス・img 保護・main 最小高さなど）
 * - モジュール（modal 等）の初期化は行わない。各ページの init で行う。
 ************************************************************/
import { HeaderControl } from '../modules/header.js';
import { smoothAnchorLink } from '../utils/smoothAnchorLink.js';
// import { loadIncludes } from './loadNavigation.js';

/**
 * 全画面共通初期化処理
 * @param {Object} ctx - リソース（新旧両対応）
 * @param {Object} [ctx.scope] - 新: createPage から渡されるスコープ
 * @param {Object} [ctx.bag] - 旧: disposeBag
 * @param {AbortSignal} [ctx.signal] - 旧: AbortSignal
 */
export async function initCommon(ctx) {
  const signal = ctx.scope?.signal ?? ctx.signal;

  // header/footerの読み込み（最初に実行）
  // await loadIncludes(signal);

  // 全画面共通で実行される処理
  new HeaderControl('[data-module="header"]', {});
  smoothAnchorLink(signal);

  // JS 有効時用クラス削除（no-js / is_nojs）
  document.body.classList.remove('no-js');
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
  const footer = document.querySelector('.footer');

  if (main && footer) {
    const setMainMinHeight = () => {
      const viewportHeight = window.innerHeight;
      const footerHeight = footer.offsetHeight;
      const minHeight = viewportHeight - footerHeight;
      main.style.minHeight = `${minHeight}px`;
    };

    // 初期設定
    setMainMinHeight();

    // リサイズ時にも再計算
    window.addEventListener('resize', setMainMinHeight, { signal });
  }
}
