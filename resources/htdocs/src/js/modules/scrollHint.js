/************************************************************
 * スクロールヒント　※scroll-hint.jsの読み込みが必要
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';

/**
 * スクロールヒント制御クラス
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
      target = '.js-scrollable',
      i18n = { scrollable: 'scroll' },
      remainingTime = 5000,
      suggestiveShadow = true,
      scrollHintIconAppendClass = 'scroll-hint-icon-white'
    } = this.options;

    const scrollHintInstance = new ScrollHint(target, {
      i18n: i18n,
      remainingTime: remainingTime,
      suggestiveShadow: suggestiveShadow,
      scrollHintIconAppendClass: scrollHintIconAppendClass
    });

    // ScrollHintインスタンスをbagに登録（destroyメソッドがある場合）
    if (scrollHintInstance && typeof scrollHintInstance.destroy === 'function') {
      bag.dispose(scrollHintInstance, 'destroy');
    }
  }
}
