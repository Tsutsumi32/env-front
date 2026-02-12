/************************************************************
 * sample-aboutページ
 *
 * Aboutページ用のJavaScriptファイル
 ************************************************************/
import { BasePageClass } from '../core/BasePage.js';
import { ThemeToggle } from '../modules/themeToggle.js';

// BasePageClassをインスタンス化（DOM完了後に自動実行）
new BasePageClass('body', () => {
  console.log('sample-about page initialized');

  // テーマ切替の初期化
  new ThemeToggle();
});
