/************************************************************
 * トップページ（ホーム）
 * - 本ファイルがエントリとして読み込まれたときに bootPage(start) で起動
 * - body をルートに createPage で初期化
 ************************************************************/

import { createPage } from '../lifecycle/createPage.js';
import { bootPage } from '../lifecycle/bootPage.js';
import { delegate } from '../utils/delegate.js';
import { modal } from '../modules/modal.js';
import { accordion } from '../modules/accordion.js';

/**
 * ページ初期化処理
 */
const start = createPage({
  getRoot: () => document.body,
  init: ({ root }) => {
    modal.init({
      onAfterOpen: ({ id }) => {
        // 必要に応じてプロジェクト固有処理を追加
        // 例: sendEvent('modal_opened', { id });
        void id;
      },
      onAfterClose: () => {
        // 必要に応じてクローズ後の処理を追加
      },
    });
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
