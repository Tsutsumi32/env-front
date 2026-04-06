/************************************************************
 * スコープ（AbortController 中心）
 * - ページ/モジュールのライフサイクルとクリーンアップを管理
 * - signal でイベント解除、onDispose でその他の後片付け
 ************************************************************/

/**
 * スコープを生成する（親 signal があれば連動して abort）
 * @param {AbortSignal} [parentSignal] - 親の AbortSignal（省略可）
 * @returns {{ signal: AbortSignal, onDispose: (fn: () => void) => void, dispose: () => void }}
 */
export const createScope = (parentSignal) => {
  const ac = new AbortController();

  if (parentSignal) {
    if (parentSignal.aborted) {
      ac.abort();
    } else {
      parentSignal.addEventListener('abort', () => ac.abort(), { once: true });
    }
  }

  /** 破棄時に実行する関数を登録 */
  const onDispose = (fn) => {
    ac.signal.addEventListener('abort', fn, { once: true });
  };

  return {
    signal: ac.signal,
    onDispose,
    dispose: () => ac.abort(),
  };
};
