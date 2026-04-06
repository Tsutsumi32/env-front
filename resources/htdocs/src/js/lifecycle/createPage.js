/************************************************************
 * ページ生成（BasePageClass の置き換え）
 * - root 取得 → ページ固有 init（MPA: ドキュメント寿命のため破棄用スコープは持たない）
 * - 共通処理は bootPage 側で initCommon を1回だけ実行
 * - 画面ごとの差分は各 pages/* の init 内でオプション・import に寄せる
 ************************************************************/

/**
 * ページ用の start 関数を返すファクトリ
 * @param {{ getRoot?: () => Element | null, init?: ({ root: Element }) => void }} options
 * @returns {() => void} start 関数
 */
export const createPage = ({ getRoot, init }) => {
  return () => {
    const root = getRoot?.() ?? null;
    if (!root) return;

    init?.({ root });
  };
};
