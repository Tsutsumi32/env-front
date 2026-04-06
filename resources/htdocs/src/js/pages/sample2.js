//**ページ初期化の構成サンプル**
/************************************************************
 * トップページ（ホーム）
 * - body をルートに createPage で初期化（起動は entry から bootPage）
 * - モジュールの初期化はページ側で行う（modal 等）
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
  // ページルート設定
  getRoot: () => document.body,
  // 画面内の処理を実装
  init: ({ root }) => {
    modal.init({
      onAfterOpen: ({ id }) => {
        // 必要に応じてプロジェクト固有処理を追加
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
