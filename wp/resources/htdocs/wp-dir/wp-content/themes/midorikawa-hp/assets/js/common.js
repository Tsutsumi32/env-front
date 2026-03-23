/********************************************************************/
/* 共通処理
/********************************************************************/

/** ブレイクポイント(以上) */
const BREAK_WIDTH_PC = 960;

/*******************************************/
/* 読み込み時各種共通処理
/*******************************************/
$(() => {
  // hover要素 ios SPのactive対応のため
  $('body').attr('ontouchstart', '');

  // 画像保存制御
  $('img').attr('oncontextmenu', 'return false;');
  $('img').attr('onselectstart', 'return false;');
  $('img').attr('onmousedown', 'return false;');

  // スクロールが発生しないコンテンツ量の場合、フッターを画面下部に配置する
  let windowH = $(window).height();
  let footerPosition = $("footer").offset().top;
  let footerH = $("footer").outerHeight();
  let footerOH = $("footer").outerHeight(true);
  if (windowH > footerPosition + footerH) {
    //元々指定しているmargin分
    const footerMT = footerOH - footerH;
    //追加margin分
    const addMT = windowH - footerPosition - footerH;
    $("footer").css("margin-top", footerMT + addMT - 2);
  }

  // スクロールアニメーション
  scrollShowAnimation();

  // パンくずの幅調整
  bredWidth();
});

$(window).on('load', function () {
  setTimeout(() => {
    // MVアニメ制御用セッション
    sessionStorage.setItem('first', true);
  }, 2000);
});

$(window).on('resize', () => {
  // パンくずの幅調整
  bredWidth();
})

/*******************************************/
/* メソッド
/*******************************************/
// PCレイアウトかどうか判定
const isPc = () => {
  return window.innerWidth >= BREAK_WIDTH_PC ? true : false;
}

/**
 * アコーディオン開閉処理
 * @param {HTMLElement} $button アコーディオンボタン
 */
const accordionToggle = ($button) => {
  const $PARENT = $button.parents('.js_accordionParent');
  const $ITEM = $PARENT.find('.js_accordionContents');
  const $BUTTON = $button;

  $ITEM.slideToggle(300);
  $ITEM.toggleClass('is_active');

  $BUTTON.toggleClass('is_active');

  if ($('.js_accordionMenuBtn').length) {
    $PARENT.find('.js_accordionMenuBtn').toggleClass('is_active');
  }
}

/**
 * アコーディオン閉処理
 * @param {HTMLElement} $obj　アコーディオン内の要素(ボタン含む)
 */
const accordionClose = ($obj = false) => {
  let $item;
  let $button;
  if ($obj) {
    const $PARENT = $obj.parents('.js_accordionParent');
    $item = $PARENT.find('.js_accordionContents');
    $button = $PARENT.find('.js_accordionBtn');
  } else {
    $item = $('.js_accordionContents');
    $button = $('.js_accordionBtn');
  }

  $item.slideUp(300);
  $item.removeClass('is_active');

  $button.removeClass('is_active');
}

/**
 * headerメニュー開閉処理
 */
const toggleHeaderMenu = () => {
  $('.js_headerMenu').slideToggle(300);
  $('.js_headerMenuBtn').toggleClass('is_active');
  $('.js_header').toggleClass('is_menuOpen');
}

/**
 * headerメニュー閉じる処理
 */
const closeHeaderMenu = () => {
  setTimeout(() => {
    $('.js_headerMenu').slideUp(300);
  }, 100)
  $('.js_headerMenuBtn').removeClass('is_active');
  onScrollNoBar();
  $('.js_header').removeClass('is_menuOpen');
}

/**
 * スクロール禁止(スクロールバー非表示、body禁止)
 */
const fixScrollNoBar = () => {
  $('body').css('overflow', 'hidden');
}

/**
 * スクロール開始(スクロールバー非表示、body禁止)
 */
const onScrollNoBar = () => {
  $('body').css('overflow', 'visible');
}

/**
 * event.preventDefault()
 */
const preventDefault = event => {
  event.preventDefault();
}

/**
 * スクロール禁止(スクロールバー表示のまま、全体禁止)
 */
const fixScroll = () => {
  document.addEventListener('touchmove', preventDefault, { passive: false });
  document.addEventListener('mousewheel', preventDefault, { passive: false });
}

/**
 * スクロール開始(スクロールバー表示のまま、全体禁止)
 */
const onScroll = () => {
  document.removeEventListener('touchmove', preventDefault, { passive: false });
  document.removeEventListener('mousewheel', preventDefault, { passive: false });
}

/**
 * モーダル表示処理
 * @param string target data-modal属性の値(ターゲットとなるモーダル指定)
 */
const openModal = (target) => {
  $(`.js_modal[data-modal="${target}"]`).fadeIn(400).css('display', 'flex');
  fixScrollNoBar();
}

/**
 * モーダル閉じる処理
 */
const closeModal = () => {
  $('.js_modal').fadeOut(400);
  setTimeout(() => {
    onScrollNoBar();
    $('.js_modalScroll').scrollTop(0);
  }, 400)
}

/**
 * スクロールアニメーション発火タイミング
 * @param $ $object 発火タイミングとなる基準のオブジェクト
 * @param int delay 遅延高さ
 */
const scrollAnimationRangeIn = ($object, delay) => {
  if ($(window).scrollTop() >= $object.offset().top - $(window).height() + delay) {
    return true;
  }
}

/**
 * スクロールアニメーション削除タイミング
 * @param $ $object 削除タイミングとなる基準のオブジェクト
 */
const scrollAnimationRangeOut = ($object) => {
  if ($(window).scrollTop() < $object.offset().top - $(window).height()) {
    return true;
  }
}

/**
 * スクロール表示アニメーション
 */
const scrollShowAnimation = () => {
  // アニメーション種別分のオブジェクト 該当タグに以下クラス指定
  const $TRANSUP = $('.js_anime_transUp');

  // アニメーション種別毎にcss用のクラスを追加
  $TRANSUP.addClass('anime_transUp');

  // 全アニメーションのオブジェクトを配列に格納
  let $objects = [];
  $objects.push($TRANSUP);

  let $delay = 0;
  if ($(window).width() < BREAK_WIDTH_PC) {
    $delay = 0;
  }

  // アニメーションの種別分以下実行
  for (let i = 0; i < $objects.length; i++) {
    // 画面読み込み時に表示範囲である場合にアクティブ化
    for (let j = 0; j < $objects[i].length; j++) {
      if (scrollAnimationRangeIn($objects[i].eq(j), $delay)) {
        $objects[i].eq(j).addClass('is_active');
      }
    }
  }

  // スクロール時に表示範囲である場合はアクティブ化
  $(window).scroll(() => {
    for (let i = 0; i < $objects.length; i++) {
      // 画面読み込み時に表示範囲である場合にアクティブ化
      for (let j = 0; j < $objects[i].length; j++) {
        if (scrollAnimationRangeIn($objects[i].eq(j), $delay)) {
          $objects[i].eq(j).addClass('is_active');
        } else if (scrollAnimationRangeOut($objects[i].eq(j))) {
          $objects[i].eq(j).removeClass('is_active');
        }
      }
    }
  })
}

/*******************************************/
/* イベント
/*******************************************/
// headerメニューボタンクリック処理
$('.js_headerMenuBtn').click(() => {
  toggleHeaderMenu();
})

// header背景クリックで閉じる処理
$('.js_headerClose').click(() => {
  closeHeaderMenu();
})

// headerメニュー内リンク押下で閉じる
$('.js_headerMenu').find('a').click(function () {
  setTimeout(() => {
    closeHeaderMenu();
    accordionClose($(this));
  }, 200);
})

// リサイズでヘッダー閉じる処理
$(window).on('resize', () => {
  if ($(window).width() >= BREAK_WIDTH_PC) {
    closeHeaderMenu();
  }
})

// アコーディオン
$('.js_accordionBtn').click(function (event) {
  // 中のaタグがクリックされた場合は何もしない
  if ($(event.target).closest('a').length > 0) {
    return;
  }
  accordionToggle($(this));
})

// アコーディオンの中身クリックで閉じる
$('.js_accordionItem').click(function () {
  accordionClose($(this));
})

//モーダル表示
$('.js_modalOpen').click(function () {
  const TARGET = $(this).attr('data-modal');
  openModal(TARGET);
});

// モーダル非表示
$('.js_modalClose').click(() => {
  closeModal();
});

//ページ内リンククリック時処理
$('a').click(function () {
  let href = $(this).attr("href");
  if (href.indexOf("#") > -1) {
    const SPEED = 500;
    const SPLIT = href.split("#");
    href = "#" + SPLIT[1];
    const TARGET = $(href == "#" || href == "" ? 'html' : href);
    const OFFSET = TARGET.offset().top;
    // 該当要素のpaddingを取得して、paddingがない位置を取得する
    const COMPUTED_STYLE = window.getComputedStyle(TARGET[0]);
    const PADDING_TOP = parseFloat(COMPUTED_STYLE.getPropertyValue('padding-block-start'));
    const CONTENT_TOP = OFFSET + PADDING_TOP;
    // 位置調整文(+:下 -：上)
    const OFFDET_ADJUSTMENT = -30;
    // 該当要素が存在する場合のみスムーススクロール
    if (TARGET.length) {
      const POSITION = CONTENT_TOP - $("header").height() + OFFDET_ADJUSTMENT;
      $("html, body").animate({ scrollTop: POSITION }, SPEED, "swing");
      return false;
    }
  }
});


/**
 * パンくずの幅調整
 */
const bredWidth = () => {
  const container = document.querySelector(".js_bred");
  const items = document.querySelectorAll(".js_bredList");
  if (!container || items.length === 0) return;

  const containerWidth = container.getBoundingClientRect().width;

  let usedWidth = 0;

  items.forEach((item, index) => {
    if (index !== items.length - 1) {
      const rect = item.getBoundingClientRect();
      const style = window.getComputedStyle(item);
      const marginLeft = parseFloat(style.marginLeft);
      const marginRight = parseFloat(style.marginRight);
      usedWidth += rect.width + marginLeft + marginRight;
    }
  });

  const remainingWidth = containerWidth - usedWidth;

  // .js-bred-list の中の .js-bred-item をターゲット
  const lastItemWrapper = items[items.length - 1];
  const lastItemSpan = lastItemWrapper.querySelector(".js_bredItem span");

  if (lastItemSpan && remainingWidth > 0) {
    lastItemSpan.style.maxWidth = `calc(${remainingWidth}px - 3rem)`;
    lastItemSpan.style.overflow = "hidden";
    lastItemSpan.style.textOverflow = "ellipsis";
    lastItemSpan.style.whiteSpace = "nowrap";
  }
}

// ヘッダーマウスホバー ヘッダーメニュー
$('.js_headerSubMenuParent').mouseenter(function () {
  const TARGET = $(this).find('.js_headerSubMenu');
  TARGET.fadeIn(200);
})

$('.js_headerSubMenuParent').mouseleave(function () {
  const TARGET = $(this).find('.js_headerSubMenu');
  TARGET.fadeOut(200);
})

// ローディングを表示する(js_loading要素押下時)
$(function () {
  // .js_loading があるかを確認
  if ($('.js_loading').length > 0) {
    // ローディングHTMLを挿入
    const loadingHTML = `
      <div class="el_loading" id="loading">
        <div class="el_loading_spinner"></div>
      </div>
    `;
    $('body').append(loadingHTML);

    // ローディングを表示
    $('.js_loading').each(function () {
      const $el = $(this);

      // 最低秒数確保
      if ($el.is('a')) {
        $el.on('click', function (e) {
          e.preventDefault();
          $('#loading').show();

          const href = $(this).attr('href');
          setTimeout(function () {
            window.location.href = href;
          }, 300);
        });
      }

      if ($el.is('button[type="submit"], input[type="submit"]')) {
        $el.on('click', function (e) {
          e.preventDefault();
          $('#loading').show();

          const $form = $(this).parents('form');
          setTimeout(function () {
            $form.off('submit').submit(); // submitハンドラを一時解除して再送信
          }, 300);
        });
      }
    });

    // ブラウザバック対応
    $(window).on('pageshow', function () {
      $('#loading').hide();
    });
  }
});

/**
 * 検索やページング時に、スクロール位置を検索結果の位置に合わせる
 *
 */
$(function() {
  const params = new URLSearchParams(window.location.search);
  if (params.size > 0) {
    const $target = $('.js_searchResult');
    if ($target.length > 0) {
      // 即座にスクロール（スムーズなし）
      const position = $target.offset().top - $('header').height();
      $(window).scrollTop(position);
    }
  }
});