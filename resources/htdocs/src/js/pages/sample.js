/************************************************************
 * トップページ（ホーム）
 * - 本ファイルがエントリとして読み込まれたときに bootPage(start) で起動
 * - data-scope="home" をルートに createPage で初期化。MPA 想定で scope は渡さない
 ************************************************************/

import { DATA_ATTR } from '../constans/global.js';
import { createPage } from '../lifecycle/createPage.js';
import { bootPage } from '../lifecycle/bootPage.js';
import { delegate } from '../utils/delegate.js';
// プロジェクトでモーダルを拡張する場合は modules/extensions/modal を import
import { modal } from '../modules/extensions/modal.js';
import { accordion } from '../modules/accordion.js';

/**
 * ページ初期化処理
 */
const start = createPage({
  getRoot: () =>
    document.querySelector(`[${DATA_ATTR.SCOPE}="home"]`),
  init: ({ root }) => {
    modal.init({});
    accordion.init({ root });

    delegate(root, 'click', {
      'page.sampleClick': (e, el) => {
        e.preventDefault();
        console.log('サンプルボタンがクリックされました', el);
        if (el.dataset.message) {
          console.log(el.dataset.message);
        }
      },
    });
  },
});

// 初期化
bootPage(start);
