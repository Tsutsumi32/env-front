/************************************************************
 * ページ生成（BasePageClass の置き換え）
 * - root 取得 → scope 生成 → initCommon 必須 → ページ固有 init → cleanup 返却
 ************************************************************/

import { createScope } from './scope.js';
// import { initCommon } from '../common/initCommon.js';

/**
 * ページ用の start 関数を返すファクトリ
 * @param {{ getRoot?: (ctx: Object) => Element | null, init?: (ctx: Object) => void }} options
 * @returns {(ctx?: Object) => () => void} cleanup を返す start 関数
 */
export const createPage = ({ getRoot, init }) => {
  return (ctx = {}) => {
    const root = ctx.root ?? getRoot?.(ctx);
    if (!root) return () => {};

    const scope = createScope();

    // 全ページ共通（必ず通す）
    // initCommon({ ...ctx, root, scope });

    // ページ固有の初期化
    init?.({ ...ctx, root, scope });

    return () => scope.dispose();
  };
};
