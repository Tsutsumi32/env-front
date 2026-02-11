/************************************************************
 * アコーディオン
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';
import { slideDown, slideUp } from '../utils/slideAnimation.js';

/**
 * アコーディオン制御クラス
 */
export class AccordionControl extends BaseModuleClass {
  /**
   * 初期化処理　オーバーライド
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      btnSelector = '.js_accordionBtn',
      parentSelector = '.js_accordionParent',
      contentSelector = '.js_accordionContents',
      activeClass = 'is_active',
      animationDuration = 300,
      hideButtonOnOpen = false,
      hideButtonSelector = null,
    } = this.options;

    // アコーディオン
    const accordionBtns = document.querySelectorAll(btnSelector);
    accordionBtns.forEach((btn) => {
      // 初期状態：親が開いていればボタンにも is_active を付与
      const parent = btn.closest(parentSelector);
      if (parent?.classList.contains(activeClass)) {
        btn.classList.add(activeClass);
      }

      btn.addEventListener(
        'click',
        (event) => {
          // 中のaタグがクリックされた場合は何もしない
          if (event.target.closest('a')) {
            return;
          }
          this.accordionToggle(btn, {
            parentSelector,
            contentSelector,
            activeClass,
            animationDuration,
            hideButtonOnOpen,
            hideButtonSelector,
            signal,
          });
        },
        { signal }
      );
    });
  }

  /**
   * アコーディオン開閉処理
   * @param {HTMLElement} button - アコーディオンボタン
   * @param {Object} options - 設定オプション
   * @param {AbortSignal} options.signal - AbortSignal
   */
  accordionToggle(button, options = {}) {
    const {
      parentSelector = '.js_accordionParent',
      contentSelector = '.js_accordionContents',
      activeClass = 'is_active',
      animationDuration = 300,
      hideButtonOnOpen = false,
      hideButtonSelector = null,
      signal,
    } = options;

    const parent = button.closest(parentSelector);
    if (!parent) return;
    const items = parent.querySelectorAll(contentSelector);

    if (items.length) {
      const isOpening = !parent.classList.contains(activeClass);
      items.forEach((item) => {
        if (isOpening) {
          slideDown(item, animationDuration, 'ease-out', signal);
        } else {
          slideUp(item, animationDuration, 'ease-out', signal);
        }
      });
      parent.classList.toggle(activeClass);
      button.classList.toggle(activeClass);

      // 展開時にボタンを非表示にする
      if (isOpening && hideButtonOnOpen) {
        // 特定のセレクタが指定されている場合は、そのセレクタに一致するボタンのみ非表示
        if (hideButtonSelector) {
          if (button.matches(hideButtonSelector)) {
            button.style.display = 'none';
          }
        } else {
          // セレクタが指定されていない場合は、クリックされたボタンを非表示
          button.style.display = 'none';
        }
      }
    }
  }
}
