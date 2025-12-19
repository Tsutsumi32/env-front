/************************************************************
 * top画面
 ************************************************************/
import { BasePageClass } from '../core/BasePage.js';
import { SwiperControl, swiperBreakPoints } from '../modules/swiper.js';

// BasePageClassをインスタンス化（DOM完了後に自動実行）
new BasePageClass('#top', async () => {
  console.log('あああああああああああああ');
  console.log("いううういいい");

  // カードコンテンツのスライダー
  document.querySelectorAll('.js-card-swiper').forEach((element) => {
    new SwiperControl(element, {
      breakpoints: swiperBreakPoints({
        sp: { slidesPerView: 2 },
        tab: { slidesPerView: 2 },
        pc: { slidesPerView: 3 },
      }),
      speed: 600,
      spaceBetween: 20,
      loop: true,
    });
  });

  // TOP MVのスライダー
  document.querySelectorAll('.js-mv-slider').forEach((element) => {
    new SwiperControl(element, {
      breakpoints: swiperBreakPoints({
        sp: { slidesPerView: 1 },
        tab: { slidesPerView: 1.2 },
        pc: { slidesPerView: 1.7 },
      }),
      centeredSlides: true,
      speed: 1000,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
    });
  });

  // チョイススライダー
  document.querySelectorAll('.js-choise-slider').forEach((element) => {
    new SwiperControl(element, {
      breakpoints: swiperBreakPoints({
        sp: { slidesPerView: 1 },
        tab: { slidesPerView: 1.2, enable: false },
        pc: { slidesPerView: 1.7, enable: false },
      }),
      spaceBetween: 100,
      speed: 600,
      loop: false,
    });
  });

  // テキストスクロールスライダー（ずっと流れ続ける）
  document.querySelectorAll('.js-textScroll').forEach((element) => {
    new SwiperControl(element, {
      mode: 'linear',
      speed: 15000,
      allowTouchMove: false,
    });
  });
});
