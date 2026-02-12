/************************************************************
 * スクロールヒント　CDN想定の実装
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化）
// ---------------------------------------------------------------------------
const ATTR_SCROLL_HINT = 'data-scroll-hint';
const SELECTOR_SCROLL_HINT = `[${ATTR_SCROLL_HINT}]`;

/**
 * スクロールヒント制御クラス
 * @requires [data-scroll-hint] - スクロール可能な対象要素（または options.target で指定）
 */
export class ScrollHintControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      target = SELECTOR_SCROLL_HINT,
      i18n = { scrollable: 'scroll' },
      remainingTime = 5000,
      suggestiveShadow = true,
      scrollHintIconAppendClass = 'scroll-hint-icon-white',
    } = this.options;

    const scrollHintInstance = new ScrollHint(target, {
      i18n: i18n,
      remainingTime: remainingTime,
      suggestiveShadow: suggestiveShadow,
      scrollHintIconAppendClass: scrollHintIconAppendClass,
    });

    // ScrollHintインスタンスをbagに登録（destroyメソッドがある場合）
    if (scrollHintInstance && typeof scrollHintInstance.destroy === 'function') {
      bag.dispose(scrollHintInstance, 'destroy');
    }
  }
}
