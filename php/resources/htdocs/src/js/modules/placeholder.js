/************************************************************
 * ボタンセレクト（検索入力）
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';

/**
 * ボタンセレクト制御クラス
 * el_buttonSelectのplaceholder機能を提供
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
      inputSelector = '.el_buttonSelect__input',
      placeholderSelector = '.el_buttonSelect__placeholder'
    } = this.options;

    // el_buttonSelectのplaceholder機能
    const buttonSelectInputs = document.querySelectorAll(inputSelector);
    buttonSelectInputs.forEach(input => {
      const placeholder = input.parentElement.querySelector(placeholderSelector);
      if (!placeholder) return;

      // 初期状態のチェック
      const updatePlaceholder = () => {
        if (input.value.trim() === '') {
          placeholder.classList.remove('is_hidden');
        } else {
          placeholder.classList.add('is_hidden');
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

