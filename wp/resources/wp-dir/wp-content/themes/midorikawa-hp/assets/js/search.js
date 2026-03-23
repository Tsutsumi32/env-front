/********************************************************************/
/* 検索関連処理
/********************************************************************/

document.addEventListener('DOMContentLoaded', () => {
  const resetBtn = document.querySelector('.js_searchClear');
  const input = document.querySelector('.js_searchText');
  const tags = document.querySelectorAll('.js_searchCb');

  // リセット処理
  resetBtn.addEventListener('click', () => {
    input.value = "";
    tags.forEach(tag => {
      tag.checked = false;
    })
  })
})