/********************************************************************/
/* アンカーリンク関連処理
/********************************************************************/

window.addEventListener('scroll', () => {
const $LINKS = $('.js_anchorLink');
  const $TARGETS = $('.js_anchorLinkTarget');
  const TARGETS_POSITION = [];
  // 位置調成分 加えた分だけ、判定位置が該当要素より下になる
  const OFFSET_ADJUSTMENT = -50;
  for(let i=0; i < $TARGETS.length; i++) {
    //該当要素のpaddingを取得して、paddingがない位置を取得する
    const OFFSET = $TARGETS.eq(i).offset().top;
    const COMPUTED_STYLE = window.getComputedStyle($TARGETS.eq(i)[0]);
    const PADDING_TOP = parseFloat(COMPUTED_STYLE.getPropertyValue('padding-block-start'));
    const CONTENT_TOP = OFFSET + PADDING_TOP;

    const POSITION = CONTENT_TOP - $('header').height() + OFFSET_ADJUSTMENT;
    TARGETS_POSITION.push(POSITION);
  }
  for(let i=0; i < $TARGETS.length; i++) {
    if($(window).scrollTop() <= TARGETS_POSITION[1]) {
      $LINKS.removeClass('is_active');
      $LINKS.eq(0).addClass('is_active');
    } else if(($(window).scrollTop() >= TARGETS_POSITION[i]) && ($(window).scrollTop() <= TARGETS_POSITION[i + 1])) {
      $LINKS.removeClass('is_active');
      $LINKS.eq(i).addClass('is_active');
    } else if($(window).scrollTop() >= TARGETS_POSITION[$TARGETS.length - 1]) {
      $LINKS.removeClass('is_active');
      $LINKS.eq($TARGETS.length - 1).addClass('is_active');
    }
  }
});

// SPのメニューテキスト変更処理
document.addEventListener('DOMContentLoaded', () => {
  const menuItems = document.querySelectorAll('.js_selectTextItem');
  const text = document.querySelector('.js_selectText');

  menuItems.forEach(item => {
    item.addEventListener('click', () => {
      text.textContent = item.textContent;
    })
  })
})