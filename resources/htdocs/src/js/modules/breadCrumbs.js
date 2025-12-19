/************************************************************
 * パンくずリスト
 * - 横幅を調整する(1行に納め、末尾のリストを末尾省略)
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';

/**
 * パンくずリスト制御クラス
 */
export class BreadCrumbsControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      containerSelector = '.js-bred',
      itemSelector = '.js-bred-item',
      itemWrapperClass = '.c-breadcrumbs__item',
      itemSpanClass = 'span',
      marginOffset = 16
    } = this.options;

    const container = document.querySelector(containerSelector);
    if (!container) {
      console.warn('パンくずリスト要素が見つかりません。');
      return;
    }

    const items = container.querySelectorAll(itemSelector);

    if (!items || items.length === 0) {
      console.warn('パンくずリストのアイテムが見つかりません。');
      return;
    }

    /**
     * パンくずリストの横幅を調整
     */
    const adjustBreadWidth = () => {
      const containerWidth = container.getBoundingClientRect().width;
      let usedWidth = 0;

      items.forEach((item, index) => {
        if (index !== items.length - 1) {
          const rect = item.getBoundingClientRect();
          const style = window.getComputedStyle(item);
          const marginLeft = parseFloat(style.marginLeft);
          const marginRight = parseFloat(style.marginRight);
          usedWidth += rect.width + marginLeft + marginRight;
        }
      });

      const remainingWidth = containerWidth - usedWidth;

      // 最後のアイテムのラッパーをターゲット
      const lastItemWrapper = items[items.length - 1];
      const lastItemSpan = lastItemWrapper.querySelector(`${itemWrapperClass} ${itemSpanClass}`);

      if (lastItemSpan && remainingWidth > 0) {
        lastItemSpan.style.maxWidth = remainingWidth - marginOffset + 'px';
        lastItemSpan.style.overflow = 'hidden';
        lastItemSpan.style.textOverflow = 'ellipsis';
        lastItemSpan.style.whiteSpace = 'nowrap';
      }
    };

    // 初期実行
    adjustBreadWidth();

    // リサイズ時にも再計算
    window.addEventListener('resize', () => {
      adjustBreadWidth();
    }, { signal });
  }
}
