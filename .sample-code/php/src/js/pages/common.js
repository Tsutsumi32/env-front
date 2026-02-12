/************************************************************
 * 指定なし画面
 ************************************************************/
import { BasePageClass } from '../core/BasePage.js';

// BasePageClassをインスタンス化（DOM完了後に自動実行）
new BasePageClass('body', () => {
  console.log('common');
});
