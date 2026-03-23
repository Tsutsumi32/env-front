/********************************************************************/
/* 採用情報画面固有処理
/********************************************************************/

document.addEventListener("DOMContentLoaded", () => {
  const interviewSwiper = new Swiper('.js_interviewSlider', {
    navigation: {
      nextEl: '.js_next',
      prevEl: '.js_prev',
    },
    pagination: {
      el: '.js_pagination',
    },
    loop: true,
    slidesPerView: 1.2,
    spaceBetween: 20,
    centeredSlides: true,
    speed: 1000,
    autoplay: {
      delay: 4800,
      disableOnInteraction: false,
      waitForTransition: false,
    },
    breakpoints: {
      960: {
        slidesPerView: 1.8,
        centeredSlides: false,
      }
    },
  });
})
