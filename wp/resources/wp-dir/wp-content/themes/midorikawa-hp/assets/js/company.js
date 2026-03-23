/********************************************************************/
/* 会社概要画面固有処理
/********************************************************************/

document.addEventListener("DOMContentLoaded", () => {
  // fadeIn使うためjQuery
  const historyContents = $('.js_historyContents');
  const historyBtn = document.querySelector('.js_historyBtn');

  historyBtn.addEventListener('click', () => {
    historyContents.fadeIn();
    historyBtn.style.display = 'none';
  })
});