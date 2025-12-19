import { BaseModuleClass } from '../core/BaseModuleClass.js';
import { THEME_STORAGE_KEY } from '../utils/themeSystemInit.js';

/**
 * テーマ切替制御クラス
 * 切り替えボタンの機能のみを提供します。
 * システム設定からの初期化は themeSystemInit.js で行います。
 *
 * @requires .js_themeToggle - テーマ切替ボタン（data-theme属性でモードを指定）
 * @example
 * <button class="js_themeToggle" data-theme="dark">ダークモード</button>
 * <button class="js_themeToggle" data-theme="default">ライトモード</button>
 */
export class ThemeToggle extends BaseModuleClass {
  /**
   * ストレージキー（themeSystemInit.jsと統一）
   */
  static STORAGE_KEY = THEME_STORAGE_KEY;

  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const { toggleButtonSelector = '.js_themeToggle', storageEnabled = true } = this.options;

    // テーマ切替ボタンの設定
    const toggleButtons = document.querySelectorAll(toggleButtonSelector);
    if (toggleButtons.length === 0) {
      return;
    }

    toggleButtons.forEach((button) => {
      button.addEventListener(
        'click',
        () => {
          const theme = button.getAttribute('data-theme');
          if (theme) {
            this.setTheme(theme, storageEnabled);
          } else {
            console.warn('data-theme属性が設定されていません。', button);
          }
        },
        { signal }
      );
    });
  }

  /**
   * テーマを設定
   * @param {string} theme - テーマ名（'default' | 'dark' など）
   * @param {boolean} saveToStorage - ストレージに保存するか
   */
  setTheme(theme, saveToStorage = true) {
    if (!theme) {
      theme = 'default';
    }

    // html要素にdata-theme属性を設定
    document.documentElement.setAttribute('data-theme', theme);

    // ストレージに保存
    if (saveToStorage) {
      try {
        localStorage.setItem(ThemeToggle.STORAGE_KEY, theme);
      } catch (e) {
        console.warn('ローカルストレージへの保存に失敗しました。', e);
      }
    }

    // カスタムイベントを発火（他のスクリプトでテーマ変更を監視可能）
    const event = new CustomEvent('themechange', {
      detail: { theme },
    });
    document.dispatchEvent(event);
  }

  /**
   * 現在のテーマを取得
   * @returns {string} 現在のテーマ名
   */
  getCurrentTheme() {
    return document.documentElement.getAttribute('data-theme') || 'default';
  }
}
