import { BaseModuleClass } from '../core/BaseModuleClass.js';
import { fadeIn, fadeOut } from '../utils/fadeAnimation.js';
import { setUpScrollTrigger } from '../utils/setUpScrollTrigger.js';

/**
 * ページトップボタン制御クラス
 * @requires .js-page-top - ページトップボタン
 * @requires .js-mv - メインビジュアル要素
 */
export class PageTopControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      pageTopSelector = '.js-page-top',
      mvSelector = '.js-mv',
      startSelector = '.js-mv',
      mode = 'scroll',
      anchor = { position: 'top', offset: 0 },
      startAnchor = { position: 'bottom', offset: 0 },
      rangeMode = 'after',
      once = false
    } = this.options;

    const pageTop = document.querySelector(pageTopSelector);

    if (!pageTop) {
      console.warn('ページトップボタン要素が見つかりません。');
      return;
    }

    setUpScrollTrigger(
      [
        {
          startSelector: startSelector,
          mode: mode,
          anchor: anchor,
          startAnchor: startAnchor,
          rangeMode: rangeMode,
          once: once,
          onEnter: () => {
            fadeIn(pageTop, 300, true, signal);
          },
          onOut: () => {
            fadeOut(pageTop, 300, true, signal);
          },
        },
      ],
      signal
    );

    pageTop.addEventListener(
      'click',
      () => {
        window.scrollTo({
          top: 0,
          // cssでsmooth設定済み
          //behavior: "smooth"
        });
        return false;
      },
      { signal }
    );
  }
}

