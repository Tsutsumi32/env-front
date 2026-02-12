/************************************************************
 * ボタンセレクト（検索入力）
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';
import { STATE_CLASSES } from '../constans/global.js';

/**
 * ボタンセレクト制御クラス
 * プレースホルダー表示の制御を提供
 * @requires [data-button-select-input] - 入力要素
 * @requires [data-button-select-placeholder] - プレースホルダー表示要素（親要素内）
 */
export class ButtonSelectControl extends BaseModuleClass {
  /**
   * 初期化処理　オーバーライド
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      inputSelector = '[data-button-select-input]',
      placeholderSelector = '[data-button-select-placeholder]'
    } = this.options;

    // プレースホルダー表示制御
    const buttonSelectInputs = document.querySelectorAll(inputSelector);
    buttonSelectInputs.forEach(input => {
      const placeholder = input.parentElement.querySelector(placeholderSelector);
      if (!placeholder) return;

      // 初期状態のチェック
      const updatePlaceholder = () => {
        if (input.value.trim() === '') {
          placeholder.classList.remove(STATE_CLASSES.HIDDEN);
        } else {
          placeholder.classList.add(STATE_CLASSES.HIDDEN);
        }
      };

      // 入力イベント
      input.addEventListener('input', updatePlaceholder, { signal });
      // フォーカスイベント（念のため）
      input.addEventListener('focus', updatePlaceholder, { signal });
      input.addEventListener('blur', updatePlaceholder, { signal });

      // 初期状態を設定
      updatePlaceholder();
    });
  }
}

