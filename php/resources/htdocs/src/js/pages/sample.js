/************************************************************
 * sampleページ
 *
 * トップページ（サンプル）用のJavaScriptファイル
 * アコーディオン機能などを初期化します。
 ************************************************************/
import { BasePageClass } from '../core/BasePage.js';
import { AccordionControl } from '../modules/accordion.js';
import { ThemeToggle } from '../modules/themeToggle.js';

// BasePageClassをインスタンス化（DOM完了後に自動実行）
new BasePageClass('body', () => {
  console.log('sample page initialized');

  // アコーディオンの初期化
  document.querySelectorAll('.js_accordionParent').forEach((element) => {
    new AccordionControl(element, {
      btnSelector: '.js_accordionBtn',
      parentSelector: '.js_accordionParent',
      contentSelector: '.js_accordionContents',
      activeClass: 'is_active',
      animationDuration: 300,
    });
  });

  // テーマ切替の初期化
  new ThemeToggle();
});
