/************************************************************
 * トップページ（ホーム）
 * - data-scope="home" をルートに createPage で初期化（起動は entry から bootPage）
 * - モジュールの初期化はページ側で行う（modal 等）
 ************************************************************/
import { createPage } from '../lifecycle/createPage.js';
import { delegate } from '../utils/delegate.js';
import { modal } from '../modules/modal.js';

export const start = createPage({
  getRoot: () =>
    document.querySelector('[data-scope="home"]') || document.querySelector('#top'),
  init: ({ root, scope }) => {
    // モジュールの初期化（このページで使うもの）
    modal.init({ scope });

    console.log('top');
    // data-action の委譲（ページ内のボタンクリックなど）
    delegate(root, scope, {
      sampleClick: (e, el) => {
        e.preventDefault();
        console.log('サンプルボタンがクリックされました', el);
        if (el.dataset.message) {
          console.log(el.dataset.message);
        }
      },
    });
  },
});
