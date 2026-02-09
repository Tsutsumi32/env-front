/************************************************************
 * GSAPアニメーション汎用
 ************************************************************/

/* npm *******************************************************

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { BaseModuleClass } from '../core/BaseModuleClass.js';

gsap.registerPlugin(ScrollTrigger);
**************************************************************/

/**
 * GSAPアニメーション制御クラス
 * @example
 * // スクロールでフェードアップ（Y移動付き）
 * new GsapControl('.js_gsapScrollFadeUp', {
 *   mode: 'scrollFadeUp',
 *   fromY: 20,
 *   toY: 0,
 *   duration: 1.2,
 * });
 *
 * // スクロールでフェードイン
 * new GsapControl('.js_gsapScrollFadeIn', {
 *   mode: 'scrollFadeIn',
 *   duration: 1,
 * });
 *
 * // スクロールでフェードアウト
 * new GsapControl('.js_gsapScrollFadeOut', {
 *   mode: 'scrollFadeOut',
 *   startPosition: 'bottom 30%',
 *   endPosition: 'bottom top',
 * });
 *
 * // フェードスケールイン（ScrollTriggerなし）
 * new GsapControl('.js_gsapFadeScaleIn', {
 *   mode: 'fadeScaleIn',
 *   fromScale: 0.93,
 *   toScale: 1,
 *   duration: 2,
 * });
 */
export class GsapControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const { mode = 'scrollFadeUp', enableResizeRefresh = true, ...options } = this.options;

    // リサイズ時のScrollTriggerリフレッシュ設定
    if (enableResizeRefresh) {
      this.setupResizeRefresh(bag, signal);
    }

    // モードに応じて初期化
    switch (mode) {
      case 'scrollFadeUp':
        this.initScrollFadeUp(element, bag, options);
        break;
      case 'scrollFadeIn':
        this.initScrollFadeIn(element, bag, options);
        break;
      case 'scrollFadeOut':
        this.initScrollFadeOut(element, bag, options);
        break;
      case 'fadeScaleIn':
        this.initFadeScaleIn(element, bag, options);
        break;
      default:
        console.warn(`GsapControl: 不明なmode "${mode}"が指定されました。`);
    }
  }

  /**
   * リサイズ時のScrollTriggerリフレッシュ設定
   * @param {Object} bag - disposeBag
   * @param {AbortSignal} signal - AbortSignal
   * @private
   */
  setupResizeRefresh(bag, signal) {
    let resizeTimer;
    const handleResize = () => {
      if (signal?.aborted) {
        return;
      }
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (!signal?.aborted) {
          ScrollTrigger.refresh();
        }
      }, 200); // 200msのデバウンス
      // signalでタイムアウトをクリーンアップ
      if (signal) {
        signal.addEventListener('abort', () => clearTimeout(resizeTimer), { once: true });
      }
    };

    window.addEventListener('resize', handleResize, { signal });
  }

  /**
   * スクロールでフェードアップ（Y移動付き）を初期化
   * @param {HTMLElement} element - 対象要素
   * @param {Object} bag - disposeBag
   * @param {Object} options - オプション
   * @private
   */
  initScrollFadeUp(element, bag, options) {
    const {
      fromY = 20,
      toY = 0,
      duration = 1.2,
      ease = 'power2.inOut',
      startOffset = 0,
      startPosition = '90%',
      scrub = false,
      toggleActions = 'play none none reverse',
    } = options;

    let delay = startOffset;

    const animation = gsap.fromTo(
      element,
      { opacity: 0, y: fromY },
      {
        opacity: 1,
        y: toY,
        duration: duration,
        ease: ease,
        scrollTrigger: {
          trigger: element,
          start: `top+=${delay} ${startPosition}`,
          scrub: scrub,
          toggleActions: toggleActions,
        },
      }
    );

    // ScrollTriggerインスタンスをbagに登録
    if (animation.scrollTrigger) {
      bag.dispose(animation.scrollTrigger, 'kill');
    }
  }

  /**
   * スクロールでフェードインを初期化
   * @param {HTMLElement} element - 対象要素
   * @param {Object} bag - disposeBag
   * @param {Object} options - オプション
   * @private
   */
  initScrollFadeIn(element, bag, options) {
    const {
      duration = 1,
      ease = 'power2.inOut',
      startOffset = 0,
      startPosition = '90%',
      scrub = false,
      toggleActions = 'play none none reverse',
    } = options;

    let delay = startOffset;

    const animation = gsap.fromTo(
      element,
      { opacity: 0 },
      {
        opacity: 1,
        duration: duration,
        ease: ease,
        scrollTrigger: {
          trigger: element,
          start: `top+=${delay} ${startPosition}`,
          scrub: scrub,
          toggleActions: toggleActions,
        },
      }
    );

    // ScrollTriggerインスタンスをbagに登録
    if (animation.scrollTrigger) {
      bag.dispose(animation.scrollTrigger, 'kill');
    }
  }

  /**
   * スクロールでフェードアウトを初期化
   * @param {HTMLElement} element - 対象要素
   * @param {Object} bag - disposeBag
   * @param {Object} options - オプション
   * @private
   */
  initScrollFadeOut(element, bag, options) {
    const {
      ease = 'power1.inOut',
      startPosition = 'bottom 30%',
      endPosition = 'bottom top',
      scrub = true,
    } = options;

    const animation = gsap.to(element, {
      opacity: 0,
      ease: ease,
      scrollTrigger: {
        trigger: element,
        start: startPosition,
        end: endPosition,
        scrub: scrub,
      },
    });

    // ScrollTriggerインスタンスをbagに登録
    if (animation.scrollTrigger) {
      bag.dispose(animation.scrollTrigger, 'kill');
    }
  }

  /**
   * フェードスケールイン（ScrollTriggerなし）を初期化
   * @param {HTMLElement} element - 対象要素
   * @param {Object} bag - disposeBag
   * @param {Object} options - オプション
   * @private
   */
  initFadeScaleIn(element, bag, options) {
    const { fromScale = 0.93, toScale = 1, duration = 2, ease = 'power2.inOut' } = options;

    const animation = gsap.fromTo(
      element,
      { opacity: 0, scale: fromScale },
      { opacity: 1, scale: toScale, duration: duration, ease: ease }
    );

    // GSAPアニメーションをbagに登録（killメソッドで停止）
    bag.dispose(animation, 'kill');
  }
}
