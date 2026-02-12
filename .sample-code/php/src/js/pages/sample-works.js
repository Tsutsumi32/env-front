/************************************************************
 * sample-worksページ
 *
 * Worksページ用のJavaScriptファイル
 ************************************************************/
import { BasePageClass } from '../core/BasePage.js';
import { ThemeToggle } from '../modules/themeToggle.js';

// BasePageClassをインスタンス化（DOM完了後に自動実行）
new BasePageClass('body', () => {
  console.log('sample-works page initialized');

  // テーマ切替の初期化
  new ThemeToggle();
});
