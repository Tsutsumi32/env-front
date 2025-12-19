import { BaseModuleClass } from '../core/BaseModuleClass.js';

/**
 * テーマ切替制御クラス
 * @requires .js_themeToggle - テーマ切替ボタン（data-theme属性でモードを指定）
 * @example
 * <button class="js_themeToggle" data-theme="dark">ダークモード</button>
 * <button class="js_themeToggle" data-theme="default">ライトモード</button>
 */
export class ThemeToggle extends BaseModuleClass {
  /**
   * ストレージキー
   */
  static STORAGE_KEY = 'theme-mode';

  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      toggleButtonSelector = '.js_themeToggle',
      storageEnabled = true
    } = this.options;

    // 初期テーマ設定
    this.setInitialTheme(storageEnabled);

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

    // システム設定の変更を監視（OSのダークモード設定変更時）
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    const handleMediaChange = (e) => {
      // ユーザーが手動で設定していない場合のみ、システム設定を反映
      if (storageEnabled && !localStorage.getItem(ThemeToggle.STORAGE_KEY)) {
        const systemTheme = e.matches ? 'dark' : 'default';
        this.setTheme(systemTheme, false);
      }
    };

    // モダンブラウザのイベントリスナー
    if (mediaQuery.addEventListener) {
      mediaQuery.addEventListener('change', handleMediaChange, { signal });
    } else {
      // 古いブラウザ用（addEventListener が使えない場合）
      mediaQuery.addListener(handleMediaChange);
      signal.addEventListener('abort', () => {
        mediaQuery.removeListener(handleMediaChange);
      });
    }
  }

  /**
   * 初期テーマを設定
   * 優先順位: 1. localStorage > 2. システム設定 > 3. default
   * @param {boolean} storageEnabled - ストレージを使用するか
   */
  setInitialTheme(storageEnabled) {
    let theme = 'default';

    // 1. localStorageから取得（ユーザーが手動で設定した値）
    if (storageEnabled) {
      const storedTheme = localStorage.getItem(ThemeToggle.STORAGE_KEY);
      if (storedTheme) {
        theme = storedTheme;
      }
    }

    // 2. ストレージにない場合、システム設定を確認
    if (!storageEnabled || !localStorage.getItem(ThemeToggle.STORAGE_KEY)) {
      if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        theme = 'dark';
      }
    }

    this.setTheme(theme, false); // 初期設定時はストレージに保存しない（既に取得済み）
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
      detail: { theme }
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

