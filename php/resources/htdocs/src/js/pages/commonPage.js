/************************************************************
 * 共通のみページ用エントリ
 * - ページ固有の処理がない画面で使用。initCommon のみ実行し、createPage は使わない
 * - HTML では <script src="dist/commonPage.js"> を読み込む
 ************************************************************/

import { bootPage } from '../lifecycle/bootPage.js';

bootPage(() => (() => {}));
