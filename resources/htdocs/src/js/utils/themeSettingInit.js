/**
 * テーマ設定初期化ユーティリティ
 * FOUC（Flash of Unstyled Content）を防ぐため、DOMContentLoaded前に実行する
 * HTMLの<head>内のインラインスクリプトとして使用することを想定
 */

/**
 * ストレージキー（ThemeSettingクラスと統一）
 */
const THEME_STORAGE_KEY = 'theme-mode';

/**
 * テーマ設定初期化処理（同期実行）
 * @returns {string} 設定されたテーマ名
 */
export function initializeThemeSetting() {
  let theme = 'default';

  // 1. localStorageから取得（ユーザーが手動で設定した値）
  try {
    const storedTheme = localStorage.getItem(THEME_STORAGE_KEY);
    if (storedTheme) {
      theme = storedTheme;
    }
  } catch (e) {
    // localStorageが使用できない場合（プライベートモードなど）
    console.warn('ローカルストレージへのアクセスに失敗しました。', e);
  }

  // 2. ストレージにない場合、システム設定を確認
  if (!theme || theme === 'default') {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      theme = 'dark';
    }
  }

  // html要素にdata-theme属性を設定
  if (document.documentElement) {
    document.documentElement.setAttribute('data-theme', theme);
  }

  return theme;
}

// 自動実行（モジュールとしてインポートされた場合も、スクリプトとして直接読み込まれた場合も対応）
if (typeof document !== 'undefined') {
  // DOMが利用可能な場合は即座に実行
  if (document.readyState === 'loading') {
    // DOMContentLoaded前に実行
    initializeThemeSetting();
  } else {
    // 既にDOMが読み込まれている場合
    initializeThemeSetting();
  }
}
