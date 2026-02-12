/************************************************************
 * モジュール生成（BaseModuleClass の置き換え）
 * - root 取得 → scope 生成（親 signal があれば連動）→ mount → cleanup 返却
 ************************************************************/

import { createScope } from './scope.js';

/**
 * モジュール用の start 関数を返すファクトリ
 * @param {{ getRoot?: (ctx: Object) => Element | null, mount?: (ctx: Object) => void }} options
 * @returns {(ctx?: Object) => () => void} cleanup を返す start 関数
 */
export const createModule = ({ getRoot, mount }) => {
  return (ctx = {}) => {
    const root = ctx.root ?? getRoot?.(ctx);
    if (!root) return () => {};

    const scope = createScope(ctx.scope?.signal);
    mount?.({ ...ctx, root, scope });
    return () => scope.dispose();
  };
};
