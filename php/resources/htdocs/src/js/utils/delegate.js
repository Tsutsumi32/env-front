/************************************************************
 * data-action 委譲ヘルパ
 * - ページ/モジュール内で data-action を scope root で一括リスン
 * - 委譲不可イベントは警告＋登録停止、委譲非推奨は警告のみ（js-fix-2 方針）
 ************************************************************/

const 委譲不可イベント = new Set([
  'focus',
  'blur',
  'mouseenter',
  'mouseleave',
  'pointerenter',
  'pointerleave',
  'load',
  'error',
  'abort',
  'resize',
  'scroll',
  'DOMContentLoaded',
  'readystatechange',
  'unload',
  'beforeunload',
  'pagehide',
  'visibilitychange',
]);

const 委譲非推奨イベント = new Set([
  'mousemove',
  'pointermove',
  'touchmove',
  'wheel',
  'drag',
  'dragover',
  'drop',
  'input',
  'keydown',
  'keyup',
]);

const ルート表示 = (root) => {
  if (root === document) return 'document';
  if (root instanceof Element) {
    const id = root.id ? `#${root.id}` : '';
    return `<${root.tagName.toLowerCase()}${id}>`;
  }
  return String(root);
};

const warn = (eventType, root, kind) => {
  const r = ルート表示(root);
  console.warn(
    `[delegate警告] ${kind}\n  event="${eventType}" / root=${r}\n  → 委譲設計の見直しを推奨します。`
  );
};

/**
 * data-action を委譲で処理する
 * @param {Document|Element} root - 委譲のルート（document または Element）
 * @param {{ signal: AbortSignal }} scope - 解除用 signal
 * @param {Record<string, (e: Event, el: Element) => void>} handlers - action 名 → ハンドラ
 * @param {string|{ eventType?: string, selector?: string, getKey?: (el: Element) => string, suppressWarn?: boolean, force?: boolean }} [optionsOrEventType] - オプション。文字列の場合は eventType として扱う（後方互換）
 */
export const delegate = (root, scope, handlers, optionsOrEventType = {}) => {
  const options =
    typeof optionsOrEventType === 'string'
      ? { eventType: optionsOrEventType }
      : optionsOrEventType;

  const {
    eventType = 'click',
    selector = '[data-action]',
    getKey = (el) => el.dataset.action,
    suppressWarn = false,
    force = false,
  } = options;

  if (!root) return;

  if (!suppressWarn) {
    if (委譲不可イベント.has(eventType)) {
      warn(eventType, root, '委譲不可イベントです（バブリングしない/扱いが特殊）');
      if (!force) return;
    } else if (委譲非推奨イベント.has(eventType)) {
      warn(eventType, root, '委譲は非推奨です（高頻度/重い可能性）');
    }
  }

  root.addEventListener(
    eventType,
    (e) => {
      const target = e.target instanceof Element ? e.target : null;
      if (!target) return;
      const el = target.closest(selector);
      if (!el) return;
      if (root instanceof Element && !root.contains(el)) return;
      const key = getKey(el);
      const fn = handlers[key];
      if (fn) fn(e, el);
    },
    { signal: scope.signal }
  );
};
