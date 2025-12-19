/************************************************************
 * モーダル処理
 * - オープンボタン　js_modalOpen　と　data-modal(モーダルのデータと紐づけ)
 * - クローズボタン　js_modalClose
 * - モーダルに js_modal　と　data-modal
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';
import { fadeIn, fadeOut } from '../utils/fadeAnimation.js';
import { disableScroll, enableScroll } from '../utils/scrollControll.js';
import { slideUp } from '../utils/slideAnimation.js';

/**
 * モーダル制御クラス
 */
export class ModalControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      openBtnSelector = '.js_modalOpen',
      closeBtnSelector = '.js_modalClose',
      modalSelector = '.js_modal',
      activeClass = 'is_active',
      animationSpeed = 400
    } = this.options;

    const MODAL_BTNS = document.querySelectorAll(openBtnSelector);
    const MODAL_CLOSE_BTN = document.querySelectorAll(closeBtnSelector);

    MODAL_BTNS.forEach((btn) => {
      btn.addEventListener(
        'click',
        (event) => {
          this.modalOpen(btn, { modalSelector, activeClass, animationSpeed, signal });
        },
        { signal }
      );
    });

    MODAL_CLOSE_BTN.forEach((btn) => {
      btn.addEventListener(
        'click',
        (event) => {
          this.modalClose({ modalSelector, activeClass, animationSpeed, signal });
        },
        { signal }
      );
    });
  }

  /**
   * モーダルを開く
   * @param {HTMLElement} btn - オープンボタン
   * @param {Object} options - オプション
   * @param {AbortSignal} options.signal - AbortSignal
   */
  modalOpen(btn, options = {}) {
    const {
      modalSelector = '.js_modal',
      activeClass = 'is_active',
      animationSpeed = 400,
      signal
    } = options;

    const TARGET = btn.getAttribute('data-modal');
    const MODAL_TARGET = document.querySelector(`${modalSelector}[data-modal="${TARGET}"]`);
    MODAL_TARGET.classList.add(activeClass);
    fadeIn(MODAL_TARGET, animationSpeed, true, signal);
    disableScroll(true, signal);
  }

  /**
   * モーダルを閉じる
   * @param {Object} options - オプション
   * @param {AbortSignal} options.signal - AbortSignal
   */
  modalClose(options = {}) {
    const {
      modalSelector = '.js_modal',
      activeClass = 'is_active',
      animationSpeed = 400,
      signal
    } = options;

    const MODAL = document.querySelector(`${modalSelector}.${activeClass}`);

    // js_modal_scrollAbleクラスがついた要素のスクロール位置を一番上に戻す
    if (MODAL) {
      const scrollableElements = MODAL.querySelectorAll('.js_modal_scrollAble');
      setTimeout(() => {
        scrollableElements.forEach(element => {
          element.scrollTop = 0;
        });
      }, animationSpeed);
    }

    // モーダルを閉じる
    if (MODAL) {
      fadeOut(MODAL, animationSpeed, true, signal);
      MODAL.classList.remove(activeClass);
      enableScroll(true, signal);

      // モーダルを閉じた後に、モーダル内のすべてのアコーディオンを閉じる
      setTimeout(() => {
        const accordionParents = MODAL.querySelectorAll('.js-accordion-parent.is_active');
        accordionParents.forEach(parent => {
          const content = parent.querySelector('.js-accordion-contents');
          if (content) {
            slideUp(content, 300, 'ease-out', signal);
            parent.classList.remove('is_active');
          }
        });

        // 非表示にされたボタンをすべて再度表示する
        const hiddenButtons = MODAL.querySelectorAll('button[style*="display: none"]');
        hiddenButtons.forEach(button => {
          button.style.display = '';
        });
      }, animationSpeed);
    } else {
      enableScroll(true, signal);
    }
  }
}

