document.addEventListener('DOMContentLoaded', () => {
  const slide = document.querySelectorAll('.swiper-slide');
  if (slide.length < 2) return;

  const slider = new Swiper('.js_Slider', {
    navigation: {
      nextEl: '.js_next',
      prevEl: '.js_prev',
    },
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    speed: 300,

    pagination: {
      el: '.js_pagination',
      clickable: false,
    },
  });
})