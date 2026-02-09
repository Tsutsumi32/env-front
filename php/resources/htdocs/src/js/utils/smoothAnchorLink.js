/************************************************************
 * アンカーリンクスムーススクロール
 * ページ内のアンカーリンクをクリックした際にスムーススクロールを実行
 ************************************************************/

/**
 * アンカーリンクのスムーススクロール処理を初期化
 * ページ内のアンカーリンククリック時にスムーススクロールを実行
 * ヘッダーの高さを考慮した位置調整を行う
 *
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 * @requires header - ヘッダー要素
 */
export function smoothAnchorLink(signal) {
  const anchorLinks = document.querySelectorAll('a[href^="#"]');

  if (!anchorLinks || anchorLinks.length === 0) {
    return;
  }

  anchorLinks.forEach((link) => {
    link.addEventListener('click', (e) => handleAnchorClick(e, signal), { signal });
  });
}

/**
 * アンカーリンククリック時の処理
 * @param {Event} e - クリックイベント
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 */
function handleAnchorClick(e, signal) {
  const href = e.currentTarget.getAttribute('href');

  if (!href || href === '#' || href === '#0') {
    return;
  }

  // ハッシュのみ取得
  const targetId = href.split('#')[1];
  if (!targetId) {
    return;
  }

  const targetElement = document.getElementById(targetId) || document.querySelector(href);

  if (!targetElement) {
    console.warn(`ターゲット要素 "#${targetId}" が見つかりません。`);
    return;
  }

  // デフォルト動作をキャンセル
  e.preventDefault();

  // スムーススクロール実行
  smoothScrollToElement(targetElement, signal);
}

/**
 * 指定要素までスムーススクロール
 * @param {HTMLElement} element - スクロール先の要素
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 */
function smoothScrollToElement(element, signal) {
  const SCROLL_SPEED = 500; // スクロール速度（ミリ秒）
  const OFFSET_ADJUSTMENT = 0; // 位置調整値

  // ヘッダー要素を取得
  const header = document.querySelector('header');
  const headerHeight = header ? header.offsetHeight : 0;

  // 要素の位置を取得
  const elementRect = element.getBoundingClientRect();
  const computedStyle = window.getComputedStyle(element);
  const paddingTop = parseFloat(computedStyle.getPropertyValue('padding-block-start'));
  const currentScrollY = window.scrollY;

  // スクロール位置を計算
  const targetPosition =
    currentScrollY + elementRect.top + paddingTop - headerHeight + OFFSET_ADJUSTMENT;

  // スムーススクロール実行
  smoothScrollTo(targetPosition, SCROLL_SPEED, signal);
}

/**
 * 指定位置までスムーススクロール
 * @param {number} targetPosition - スクロール先の位置
 * @param {number} duration - スクロール時間（ミリ秒）
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 */
function smoothScrollTo(targetPosition, duration, signal) {
  const startPosition = window.scrollY;
  const distance = targetPosition - startPosition;
  let startTime = null;
  let animationFrameId = null;

  /**
   * アニメーション関数
   * @param {number} currentTime - 現在時刻
   */
  function animation(currentTime) {
    if (signal?.aborted) {
      return;
    }

    if (startTime === null) startTime = currentTime;
    const timeElapsed = currentTime - startTime;
    const progress = Math.min(timeElapsed / duration, 1);

    // イージング関数（easeInOutCubic）
    const easeInOutCubic =
      progress < 0.5 ? 4 * progress * progress * progress : 1 - Math.pow(-2 * progress + 2, 3) / 2;

    window.scrollTo(0, startPosition + distance * easeInOutCubic);

    if (timeElapsed < duration) {
      animationFrameId = requestAnimationFrame(animation);
    }
  }

  animationFrameId = requestAnimationFrame(animation);

  // signalでアニメーションをキャンセル
  if (signal) {
    signal.addEventListener(
      'abort',
      () => {
        if (animationFrameId !== null) {
          cancelAnimationFrame(animationFrameId);
        }
      },
      { once: true }
    );
  }
}
