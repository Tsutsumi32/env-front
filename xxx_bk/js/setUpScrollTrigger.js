/************************************************************
 * スクロール位置で発火する処理を制御する
 * (GSAPで事足りるならGSAP利用)
 ************************************************************/

/**
 * スクロールトリガーを設定する
 * @param {Array<Object>} configs - スクロールトリガーの設定配列
 * @param {AbortSignal} [signal] - AbortSignal（クリーンアップ用）
 */
export const setUpScrollTrigger = (configs, signal) => {
  configs.forEach((config) => {
    setupMultipleTriggerRegions({
      ...config,
      signal,
    });
  });
};

/**
 * 複数のトリガー領域を設定する
 * @param {Object} options - 設定オプション
 * @param {string} options.startSelector - 開始要素のセレクター
 * @param {string} [options.endSelector=null] - 終了要素のセレクター
 * @param {string} options.targetSelector - ターゲット要素のセレクター
 * @param {string} [options.mode='target'] - モード
 * @param {Object} [options.anchor={ position: 'center', offset: 0 }] - アンカー設定
 * @param {Object} [options.startAnchor={ position: 'top', offset: 0 }] - 開始アンカー設定
 * @param {Object} [options.endAnchor={ position: 'bottom', offset: 0 }] - 終了アンカー設定
 * @param {string} [options.rangeMode='between'] - レンジモード
 * @param {boolean} [options.once=true] - 一度だけ実行するかどうか
 * @param {Function} [options.onEnter=(index, elements) => {}] - エンター時のコールバック
 * @param {Function} [options.onOut=(index, elements) => {}] - アウト時のコールバック
 * @param {AbortSignal} [options.signal] - AbortSignal（クリーンアップ用）
 */
export const setupMultipleTriggerRegions = ({
  startSelector, // 例: '#start1' or '.start'
  endSelector = null, // 例: '#end1' or '.end'
  targetSelector, // 例: '#target' or '.target'
  mode = 'target',
  anchor = { position: 'center', offset: 0 },
  startAnchor = { position: 'top', offset: 0 },
  endAnchor = { position: 'bottom', offset: 0 },
  rangeMode = 'between',
  once = true,
  onEnter = (index, elements) => {},
  onOut = (index, elements) => {},
  signal,
}) => {
  const startEls = document.querySelectorAll(startSelector);
  const endEls = endSelector ? document.querySelectorAll(endSelector) : [];
  const targetEls = document.querySelectorAll(targetSelector);

  // 複数ターゲットに対応（または最初の1つにする）
  const getTargetEl = (i) => {
    if (targetEls.length === 1) return targetEls[0];
    return targetEls[i] || targetEls[targetEls.length - 1];
  };

  startEls.forEach((startEl, i) => {
    const endEl = endSelector ? endEls[i] || endEls[endEls.length - 1] : null;
    const targetEl = getTargetEl(i);

    setupTriggerBetweenElements({
      mode,
      anchor,
      startAnchor,
      endAnchor,
      startEl,
      endEl,
      targetEl,
      rangeMode,
      once,
      onEnter: () => onEnter(i, { startEl, endEl, targetEl }),
      onOut: () => onOut(i, { startEl, endEl, targetEl }),
      signal,
    });
  });
};

const setupTriggerBetweenElements = ({
  startEl,
  endEl = null,
  targetEl,
  mode = 'scroll',
  anchor = { position: 'center', offset: 0 },
  startAnchor = { position: 'top', offset: 0 },
  endAnchor = { position: 'top', offset: 0 },
  rangeMode = 'between', // 'between' or 'after'
  once = true,
  onEnter = () => {},
  onOut = () => {},
  signal,
}) => {
  const getElementY = (el, anchor) => {
    const rect = el.getBoundingClientRect();
    const scrollY = window.scrollY;
    const base = {
      top: rect.top,
      center: rect.top + rect.height / 2,
      bottom: rect.bottom,
    }[anchor.position || 'top'];
    return scrollY + base + (anchor.offset || 0);
  };

  const getViewportY = (anchor) => {
    const scrollY = window.scrollY;
    const base = {
      top: 0,
      center: window.innerHeight / 2,
      bottom: window.innerHeight,
    }[anchor.position || 'center'];
    return scrollY + base + (anchor.offset || 0);
  };

  let hasFired = false;

  const handleCheck = () => {
    if (signal?.aborted) {
      return;
    }

    const startY = getElementY(startEl, startAnchor);
    const endY = endEl ? getElementY(endEl, endAnchor) : null;

    let checkY = mode === 'scroll' ? getViewportY(anchor) : getElementY(targetEl, anchor);

    let isInRange = false;

    if (rangeMode === 'between') {
      if (!endEl) return;
      isInRange = checkY >= startY && checkY <= endY;
    } else if (rangeMode === 'after') {
      isInRange = checkY >= startY;
    }

    if (isInRange && !hasFired) {
      onEnter();
      hasFired = true;
    }

    if (!isInRange && !once && hasFired) {
      onOut();
      hasFired = false;
    }
  };

  window.addEventListener('scroll', handleCheck, { signal });

  // resizeはdebounceで最適化（任意）
  let resizeTimer;
  window.addEventListener(
    'resize',
    () => {
      if (signal?.aborted) {
        return;
      }
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(handleCheck, 100);
      // signalでタイムアウトをクリーンアップ
      if (signal) {
        signal.addEventListener('abort', () => clearTimeout(resizeTimer), { once: true });
      }
    },
    { signal }
  );

  // 初回チェック
  handleCheck();
};
