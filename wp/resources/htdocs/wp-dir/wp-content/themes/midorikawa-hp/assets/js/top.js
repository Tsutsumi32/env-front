/********************************************************************/
/* トップ画面固有処理
/********************************************************************/

const mvSlider = () => {
  const mvSwiper = new Swiper('.js_mvSlider', {
    pagination: {
      el: '.js_pagination',
    },
    loop: true,
    slidesPerView: 1,
    effect: 'fade',
    speed: 2000,
    autoplay: {
      delay: 6000,
      disableOnInteraction: false,
      waitForTransition: false,
    },
    breakpoints: {
      960: {
        slidesPerView: 'auto',
      }
    },
  });
}

$(function() {
  if(sessionStorage.getItem('first')) {
    // セッションがある場合、アニメーション除去
    $('.js_first').hide();
    mvSlider();
  }
})

$(window).on('load', function() {
  // セッションはcommonで設定
  if(!sessionStorage.getItem('first')) {
    $('.js_firstLogo').addClass('is_show');
    $('.js_firstContents').addClass('is_first');

    fixScroll();
    setTimeout(() => {
      $('.js_firstLogo').addClass('is_remove');
    }, 2000)
    setTimeout(()=> {
      $('.js_first').fadeOut(1000);
    }, 3300)
    setTimeout(() => {
      $('.js_firstContents').removeClass('is_first');
      mvSlider();
      onScroll();
    }, 4100);
  }
})

document.addEventListener("DOMContentLoaded", () => {

  const productSwiper = new Swiper('.js_productSlider', {
    navigation: {
      nextEl: '.js_next',
      prevEl: '.js_prev',
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
      700: {
        spaceBetween: 35,
        slidesPerView: 1.6,
        centeredSlides: true,
      },
      960: {
        spaceBetween: 60,
        centeredSlides: false,
        slidesPerView: 2.7,
      }
    },
  });

  const companySwiper = new Swiper('.js_companySlider', {
    loop: true,
    slidesPerView: 1.2,
    centeredSlides: true,
    speed: 10000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      waitForTransition: false,
    },
    breakpoints: {
      960: {
        slidesPerView: 3.2,
        speed: 20000,
      }
    },
  });

  const companySwiper2 = new Swiper('.js_companySlider_reverse', {
    loop: true,
    slidesPerView: 1.2,
    centeredSlides: true,
    speed: 10000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      waitForTransition: false,
      reverseDirection: true,
    },
    breakpoints: {
      960: {
        slidesPerView: 3.2,
        speed: 20000,
      }
    },
  });
})


$(window).scroll(() => {
  // mv
  const $MV = $('.js_mv');
  if($(window).scrollTop() > $MV.height() - $('header').height()) {
    $('.js_header').removeClass('is_top');
  } else {
    $('.js_header').addClass('is_top');
  }
})