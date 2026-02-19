//**ガベージコレクション・クリーンアップ処理も考慮した構成サンプル**
/************************************************************
 * トップページ（ホーム）
 * - data-scope="home" をルートに createPage で初期化（起動は entry から bootPage）
 * - モジュールの初期化はページ側で行う（modal 等）
 ************************************************************/
import { DATA_ATTR } from '../constans/global.js';
import { createPage } from '../lifecycle/createPage.js';
import { delegate } from '../utils/delegate.js';
// プロジェクトでモーダルを拡張する場合は modules/extensions/modal を import
import { modal } from '../modules/extensions/modal.js';
import { accordion } from '../modules/accordion.js';

/**
 * ページ初期化処理
 */
const start = createPage({
   // ページルート設定
  getRoot: () =>
    document.querySelector(`[${DATA_ATTR.SCOPE}="home"]`) || document.querySelector('#top'),
   // 画面内の処理を実装
  init: ({ root, scope }) => {
    // モジュールの初期化（このページで使うもの）
    modal.init({ scope });

    accordion.init({ root, scope });

    // data-action の委譲（ページ内のボタンクリックなど）
    // 原則delegateを使用する
    // メソッド名がdata-actionの名称を同一になる
    delegate(root, 'click', {
      'page.sampleClick': (e, el) => {
        e.preventDefault();
        console.log('サンプルボタンがクリックされました', el);
        if (el.dataset.message) {
          console.log(el.dataset.message);
        }
      },
    }, scope);
  },
});

// 初期化
bootPage(start);
