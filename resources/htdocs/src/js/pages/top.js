/************************************************************
 * top画面
 ************************************************************/
import { BasePageClass } from '../core/BasePage.js';
import { SwiperControl, swiperBreakPoints } from '../modules/swiper.js';

// BasePageClassをインスタンス化（DOM完了後に自動実行）
new BasePageClass('#top', async () => {
  console.log('topページスクリプト');
});
