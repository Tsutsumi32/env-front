/************************************************************
 * HTML要素の複製
 ************************************************************/
/**
 * js_htmlCopy クラスの要素を同じ階層（兄弟として）複製するユーティリティ
 * data-copy-length 属性で複製する数を指定（指定なしの場合は 1）
 *
 * @param {Object} [options] - オプション
 * @param {Document|Element} [options.root=document] - 検索のルート要素
 *
 * @example
 * // HTML: <div class="parent"><span class="js_htmlCopy" data-copy-length="3">item</span></div>
 * // 実行後: <div class="parent"><span>item</span><span>item</span><span>item</span><span>item</span></div>
 */
export const initHtmlCopy = (options = {}) => {
  const { root = document } = options;
  const elements = root.querySelectorAll('.js_htmlCopy');

  elements.forEach((el) => {
    const copyLength = parseInt(el.dataset.copyLength, 10) || 1;
    if (copyLength <= 0) return;

    const parent = el.parentNode;
    if (!parent) return;

    let insertBeforeNode = el.nextSibling;

    for (let i = 0; i < copyLength; i++) {
      const clone = el.cloneNode(true);
      parent.insertBefore(clone, insertBeforeNode);
      insertBeforeNode = clone.nextSibling;
    }
  });
};
