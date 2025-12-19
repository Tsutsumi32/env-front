/************************************************************
 * 全画面共通初期化処理
 * - 全ページで共通して実行される処理
 ************************************************************/
import { HeaderControl } from '../modules/header.js';
import { BreadCrumbsControl } from '../modules/breadCrumbs.js';
import { PageTopControl } from '../modules/pageTop.js';
import { ThemeToggle } from '../modules/themeToggle.js';
import { smoothAnchorLink } from '../utils/smoothAnchorLink.js';
import { initializeThemeSystem, watchSystemThemeChange } from '../utils/themeSystemInit.js';

/**
 * 全画面共通初期化処理
 * @param {Object} resources - リソース
 * @param {Object} resources.bag - disposeBag
 * @param {AbortSignal} resources.signal - AbortSignal
 */
export function initCommon({ bag, signal }) {
  // テーマシステムの初期化（システム設定からテーマを設定）
  initializeThemeSystem(true);

  // システム設定の変更を監視
  watchSystemThemeChange(signal, true);

  // 全画面共通で実行される処理
  new HeaderControl('.js-header', {});
  new ThemeToggle('body', {});
  smoothAnchorLink(signal);

  // 必要に応じてコメントアウトを解除
  // new BreadCrumbsControl('.js-bred', {});
  // new PageTopControl('.js-page-top', {});

  //js無効環境の場合のクラス削除
  document.body.classList.remove('no-js');

  // img保存策
  imgDisabled(signal);
}

const imgDisabled = (signal) => {
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
};
