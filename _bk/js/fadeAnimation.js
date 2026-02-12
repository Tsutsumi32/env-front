/************************************************************
 * フェードイン・フェードアウトアニメーション
 ************************************************************/

/**
 * 要素をフェードインアニメーションで表示する
 * @param {HTMLElement} element - アニメーション対象の要素
 * @param {number} [duration=300] - アニメーション時間（ミリ秒）
 * @param {boolean} [display=true] - displayプロパティを変更するかどうか
 * @param {AbortSignal} [signal] - AbortSignal（クリーンアップ用）
 */
export const fadeIn = (element, duration = 300, display = true, signal) => {
  // element.style.opacity = 0;
  display && (element.style.display = 'block');
  const startTime = performance.now();
  let animationFrameId = null;

  const animation = (currentTime) => {
    if (signal?.aborted) {
      return;
    }

    const elapsedTime = currentTime - startTime;
    const progress = Math.min(elapsedTime / duration, 1); // 0～1の範囲に制限
    element.style.opacity = progress;
    if (progress < 1) {
      animationFrameId = requestAnimationFrame(animation);
    }
  };

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
};

/**
 * 要素をフェードアウトアニメーションで非表示にする
 * @param {HTMLElement} element - アニメーション対象の要素
 * @param {number} [duration=300] - アニメーション時間（ミリ秒）
 * @param {boolean} [display=true] - displayプロパティを変更するかどうか
 * @param {AbortSignal} [signal] - AbortSignal（クリーンアップ用）
 */
export const fadeOut = (element, duration = 300, display = true, signal) => {
  const startTime = performance.now();
  let animationFrameId = null;

  const animation = (currentTime) => {
    if (signal?.aborted) {
      return;
    }

    const elapsedTime = currentTime - startTime;
    const progress = Math.min(elapsedTime / duration, 1); // 0～1の範囲に制限
    element.style.opacity = 1 - progress;

    if (progress < 1) {
      animationFrameId = requestAnimationFrame(animation);
    } else {
      // 完全に透明になったら非表示
      display && (element.style.display = 'none');
    }
  };

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
};
