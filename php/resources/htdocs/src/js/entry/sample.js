/************************************************************
 * トップページ用エントリ
 * - pageId に応じて読み込まれる dist/top.js の入口。bootPage で pages/top を起動
 ************************************************************/
import { bootPage } from '../lifecycle/bootPage.js';
import { start } from '../pages/sample.js';

bootPage(start);
