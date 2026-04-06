/************************************************************
 * ページ生成（BasePageClass の置き換え）
 * - root 取得 → scope 生成 → ページ固有 init → cleanup 返却
 * - 共通処理は bootPage 側で initCommon を1回だけ実行（ページ毎の破棄対象外）
 ************************************************************/

import { createScope } from './scope.js';

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

    // ページ固有の初期化
    init?.({ ...ctx, root, scope });

    return () => scope.dispose();
  };
};
