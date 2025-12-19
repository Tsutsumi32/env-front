/**
 * 疑似スクロールバー生成
 * iPhone SafariでCSSのスクロールバーが表示されない問題を解決
 */

/**
 * デフォルトのスクロールバースタイル設定
 */
export const DEFAULT_SCROLLBAR_STYLE = {
  /** 縦スクロールバーの太さ（px） */
  verticalWidth: 6,
  /** 横スクロールバーの太さ（px） */
  horizontalHeight: 2,
  /** スクロールバーの色 */
  color: '#fafafa',
  /** スクロールバートラックの色 */
  trackColor: 'transparent',
};

/**
 * 要素のデフォルトスクロールバーを非表示にする
 * @param {HTMLElement} element - 対象要素
 * @param {string} selector - セレクタ（スタイルシート用）
 */
function hideNativeScrollbar(element, selector) {
  // セレクタごとにスタイルシートを追加
  const styleId = `js-scrollbar-hide-${selector.replace(/[^a-zA-Z0-9]/g, '-')}`;
  if (document.getElementById(styleId)) {
    return;
  }

  const style = document.createElement('style');
  style.id = styleId;
  style.textContent = `
    ${selector}::-webkit-scrollbar {
      display: none;
      width: 0;
      height: 0;
    }
    ${selector} {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  `;
  document.head.appendChild(style);

  // Firefox用
  element.style.scrollbarWidth = 'none';
  // IE/Edge用
  element.style.msOverflowStyle = 'none';
}

/**
 * スクロールバーを生成・更新する（内部実装）
 * @param {HTMLElement} element - スクロール可能な要素
 * @param {Object} style - スタイル設定
 * @param {string} selector - セレクタ（スタイルシート用）
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 */
function createScrollbarInternal(element, style, selector, signal) {
  // 既存のスクロールバー要素があれば削除
  const existingVerticalScrollbar = element.querySelector('.js-scrollbar-vertical');
  const existingHorizontalScrollbar = element.querySelector('.js-scrollbar-horizontal');
  if (existingVerticalScrollbar) {
    existingVerticalScrollbar.remove();
  }
  if (existingHorizontalScrollbar) {
    existingHorizontalScrollbar.remove();
  }

  // 縦スクロール可能かチェック（実際のスクロール可能状態を判定）
  const isVerticalScrollable = element.scrollHeight > element.clientHeight;
  // 横スクロール可能かチェック（実際のスクロール可能状態を判定）
  const isHorizontalScrollable = element.scrollWidth > element.clientWidth;

  // 要素が position: relative または absolute でない場合は追加
  const computedStyle = window.getComputedStyle(element);
  if (computedStyle.position === 'static') {
    element.style.position = 'relative';
  }

  // デフォルトのスクロールバーを非表示にする
  hideNativeScrollbar(element, selector);

  // 縦スクロールバーを生成
  if (isVerticalScrollable) {
    createVerticalScrollbar(element, style, signal);
  }

  // 横スクロールバーを生成
  if (isHorizontalScrollable) {
    createHorizontalScrollbar(element, style, signal);
  }
}

/**
 * スクロールバーを生成・更新する
 * @param {string} selector - スクロール可能な要素のセレクタ
 * @param {Object} options - オプション
 * @param {number} [options.verticalWidth] - 縦スクロールバーの太さ（px）
 * @param {number} [options.horizontalHeight] - 横スクロールバーの太さ（px）
 * @param {string} [options.color] - スクロールバーの色
 * @param {string} [options.trackColor] - スクロールバートラックの色
 * @param {AbortSignal} [options.signal] - AbortSignal（クリーンアップ用）
 */
export function createScrollbar(selector, options = {}) {
  // スタイル設定をマージ
  const style = {
    verticalWidth: options.verticalWidth ?? DEFAULT_SCROLLBAR_STYLE.verticalWidth,
    horizontalHeight: options.horizontalHeight ?? DEFAULT_SCROLLBAR_STYLE.horizontalHeight,
    color: options.color ?? DEFAULT_SCROLLBAR_STYLE.color,
    trackColor: options.trackColor ?? DEFAULT_SCROLLBAR_STYLE.trackColor,
  };

  const { signal } = options;

  // セレクタで要素を取得
  const elements = document.querySelectorAll(selector);

  if (elements.length === 0) {
    console.warn(`スクロールバー: セレクタ "${selector}" に一致する要素が見つかりませんでした`);
    return;
  }

  // すべての要素にスクロールバーを適用
  elements.forEach((element) => {
    createScrollbarInternal(element, style, selector, signal);
  });
}

/**
 * 縦スクロールバーを生成
 * @param {HTMLElement} element - スクロール可能な要素
 * @param {Object} style - スタイル設定
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 */
function createVerticalScrollbar(element, style, signal) {
  // スクロールバーコンテナを作成
  const scrollbarContainer = document.createElement('div');
  scrollbarContainer.className = 'js-scrollbar-vertical';
  scrollbarContainer.style.cssText = `
    position: absolute;
    right: 0;
    top: 0;
    width: ${style.verticalWidth}px;
    height: 100%;
    pointer-events: none;
    z-index: 10;
  `;

  // スクロールバートラックを作成
  const scrollbarTrack = document.createElement('div');
  scrollbarTrack.className = 'js-scrollbar-track';
  scrollbarTrack.style.cssText = `
    position: relative;
    width: 100%;
    height: 100%;
    background: ${style.trackColor};
  `;

  // スクロールバーサムを作成
  const scrollbarThumb = document.createElement('div');
  scrollbarThumb.className = 'js-scrollbar-thumb';
  scrollbarThumb.style.cssText = `
    position: absolute;
    right: 0;
    width: ${style.verticalWidth}px;
    background-color: ${style.color};
    border-radius: 100vh;
    transition: opacity 0.2s ease;
  `;

  scrollbarTrack.appendChild(scrollbarThumb);
  scrollbarContainer.appendChild(scrollbarTrack);
  element.appendChild(scrollbarContainer);

  // スクロールバーのサイズと位置を更新
  function updateScrollbar() {
    if (signal?.aborted) {
      return;
    }

    const scrollHeight = element.scrollHeight;
    const clientHeight = element.clientHeight;
    const scrollTop = element.scrollTop;

    // スクロール可能でなくなった場合は削除
    if (scrollHeight <= clientHeight) {
      scrollbarContainer.remove();
      return;
    }

    // サムの高さを計算（表示領域の割合）
    const thumbHeight = (clientHeight / scrollHeight) * clientHeight;
    scrollbarThumb.style.height = `${thumbHeight}px`;

    // サムの位置を計算
    const maxScroll = scrollHeight - clientHeight;
    const thumbTop = maxScroll > 0 ? (scrollTop / maxScroll) * (clientHeight - thumbHeight) : 0;
    scrollbarThumb.style.top = `${thumbTop}px`;
  }

  // 初期更新
  updateScrollbar();

  // スクロール時に更新
  element.addEventListener('scroll', updateScrollbar, { passive: true, signal });

  // リサイズ時に更新（ResizeObserverを使用）
  if (window.ResizeObserver) {
    const resizeObserver = new ResizeObserver(() => {
      if (!signal?.aborted) {
        updateScrollbar();
      }
    });
    resizeObserver.observe(element);

    // signalでResizeObserverをクリーンアップ
    if (signal) {
      signal.addEventListener('abort', () => {
        resizeObserver.disconnect();
      }, { once: true });
    }
  }
}

/**
 * 横スクロールバーを生成
 * @param {HTMLElement} element - スクロール可能な要素
 * @param {Object} style - スタイル設定
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 */
function createHorizontalScrollbar(element, style, signal) {
  // スクロールバーコンテナを作成
  const scrollbarContainer = document.createElement('div');
  scrollbarContainer.className = 'js-scrollbar-horizontal';
  scrollbarContainer.style.cssText = `
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: ${style.horizontalHeight}px;
    pointer-events: none;
    z-index: 10;
  `;

  // スクロールバートラックを作成
  const scrollbarTrack = document.createElement('div');
  scrollbarTrack.className = 'js-scrollbar-track';
  scrollbarTrack.style.cssText = `
    position: relative;
    width: 100%;
    height: 100%;
    background: ${style.trackColor};
  `;

  // スクロールバーサムを作成
  const scrollbarThumb = document.createElement('div');
  scrollbarThumb.className = 'js-scrollbar-thumb';
  scrollbarThumb.style.cssText = `
    position: absolute;
    bottom: 0;
    height: ${style.horizontalHeight}px;
    background-color: ${style.color};
    border-radius: 100vh;
    transition: opacity 0.2s ease;
  `;

  scrollbarTrack.appendChild(scrollbarThumb);
  scrollbarContainer.appendChild(scrollbarTrack);
  element.appendChild(scrollbarContainer);

  // スクロールバーのサイズと位置を更新
  function updateScrollbar() {
    if (signal?.aborted) {
      return;
    }

    const scrollWidth = element.scrollWidth;
    const clientWidth = element.clientWidth;
    const scrollLeft = element.scrollLeft;

    // スクロール可能でなくなった場合は削除
    if (scrollWidth <= clientWidth) {
      scrollbarContainer.remove();
      return;
    }

    // サムの幅を計算（表示領域の割合）
    const thumbWidth = (clientWidth / scrollWidth) * clientWidth;
    scrollbarThumb.style.width = `${thumbWidth}px`;

    // サムの位置を計算
    const maxScroll = scrollWidth - clientWidth;
    const thumbLeft = maxScroll > 0 ? (scrollLeft / maxScroll) * (clientWidth - thumbWidth) : 0;
    scrollbarThumb.style.left = `${thumbLeft}px`;
  }

  // 初期更新
  updateScrollbar();

  // スクロール時に更新
  element.addEventListener('scroll', updateScrollbar, { passive: true, signal });

  // リサイズ時に更新（ResizeObserverを使用）
  if (window.ResizeObserver) {
    const resizeObserver = new ResizeObserver(() => {
      if (!signal?.aborted) {
        updateScrollbar();
      }
    });
    resizeObserver.observe(element);

    // signalでResizeObserverをクリーンアップ
    if (signal) {
      signal.addEventListener('abort', () => {
        resizeObserver.disconnect();
      }, { once: true });
    }
  }
}

/**
 * すべての指定されたセレクタの要素に対してスクロールバーを生成
 * @param {Object} options - オプション
 * @param {string} [options.selector] - 対象とするセレクタ（デフォルト: '.js-scrollable'）
 * @param {number} [options.verticalWidth] - 縦スクロールバーの太さ（px）
 * @param {number} [options.horizontalHeight] - 横スクロールバーの太さ（px）
 * @param {string} [options.color] - スクロールバーの色
 * @param {string} [options.trackColor] - スクロールバートラックの色
 * @param {AbortSignal} [options.signal] - AbortSignal（クリーンアップ用）
 */
export function initScrollbars(options = {}) {
  const selector = options.selector || '.js-scrollable';
  const { selector: _, ...otherOptions } = options;
  createScrollbar(selector, otherOptions);
}

/**
 * 動的に追加された要素にも対応するため、MutationObserver を設定
 * @param {string} [targetSelector] - 監視対象の要素のセレクタ（デフォルト: 'body'）
 * @param {Object} options - オプション
 * @param {string} [options.selector] - 監視する要素のセレクタ（デフォルト: '.js-scrollable'）
 * @param {number} [options.verticalWidth] - 縦スクロールバーの太さ（px）
 * @param {number} [options.horizontalHeight] - 横スクロールバーの太さ（px）
 * @param {string} [options.color] - スクロールバーの色
 * @param {string} [options.trackColor] - スクロールバートラックの色
 * @param {AbortSignal} [options.signal] - AbortSignal（クリーンアップ用）
 * @returns {MutationObserver|null} MutationObserverインスタンス
 */
export function watchScrollableElements(targetSelector = 'body', options = {}) {
  if (!window.MutationObserver) {
    return null;
  }

  const watchSelector = options.selector || '.js-scrollable';
  const { selector: _, signal, ...styleOptions } = options;

  // スタイル設定をマージ
  const style = {
    verticalWidth: styleOptions.verticalWidth ?? DEFAULT_SCROLLBAR_STYLE.verticalWidth,
    horizontalHeight: styleOptions.horizontalHeight ?? DEFAULT_SCROLLBAR_STYLE.horizontalHeight,
    color: styleOptions.color ?? DEFAULT_SCROLLBAR_STYLE.color,
    trackColor: styleOptions.trackColor ?? DEFAULT_SCROLLBAR_STYLE.trackColor,
  };

  // 監視対象の要素を取得
  const target = document.querySelector(targetSelector);
  if (!target) {
    console.warn(`スクロールバー: セレクタ "${targetSelector}" に一致する要素が見つかりませんでした`);
    return null;
  }

  const mutationObserver = new MutationObserver((mutations) => {
    if (signal?.aborted) {
      return;
    }

    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        if (node.nodeType === 1) { // Element node
          // 追加された要素が監視対象のセレクタに一致する場合
          if (node.matches && node.matches(watchSelector)) {
            createScrollbarInternal(node, style, watchSelector, signal);
          }
          // 追加された要素の子要素に監視対象のセレクタに一致する要素がある場合
          const scrollableChildren = node.querySelectorAll?.(watchSelector);
          if (scrollableChildren) {
            scrollableChildren.forEach((element) => {
              createScrollbarInternal(element, style, watchSelector, signal);
            });
          }
        }
      });
    });
  });

  mutationObserver.observe(target, {
    childList: true,
    subtree: true,
  });

  // signalでMutationObserverをクリーンアップ
  if (signal) {
    signal.addEventListener('abort', () => {
      mutationObserver.disconnect();
    }, { once: true });
  }

  return mutationObserver;
}
