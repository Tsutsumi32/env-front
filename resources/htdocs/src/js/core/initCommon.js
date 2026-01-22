/************************************************************
 * 全画面共通初期化処理
 * - 全ページで共通して実行される処理
 ************************************************************/
import { HeaderControl } from '../modules/header.js';
import { smoothAnchorLink } from '../utils/smoothAnchorLink.js';
// import { loadIncludes } from './loadNavigation.js';

/**
 * 全画面共通初期化処理
 * @param {Object} resources - リソース
 * @param {Object} resources.bag - disposeBag
 * @param {AbortSignal} resources.signal - AbortSignal
 */
export async function initCommon({ bag, signal }) {
  // header/footerの読み込み（最初に実行）
  // await loadIncludes(signal);

  // 全画面共通で実行される処理
  new HeaderControl('.js_header', {});
  smoothAnchorLink(signal);

  //js無効環境の場合のクラス削除
  document.body.classList.remove('no-js');

  // img保存策
  document.querySelectorAll('img').forEach(function (img) {
    img.addEventListener(
      'contextmenu',
      function (e) {
        e.preventDefault();
      },
      { signal }
    );
    img.addEventListener(
      'selectstart',
      function (e) {
        e.preventDefault();
      },
      { signal }
    );
    img.addEventListener(
      'mousedown',
      function (e) {
        e.preventDefault();
      },
      { signal }
    );
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
