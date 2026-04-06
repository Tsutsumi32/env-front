/************************************************************
 * GSAP アニメーション汎用（CDN 想定）
 * - data-feature="gsap" が対象。data-feature-gsap-mode の値で mode 指定（scrollFadeUp / scrollFadeIn / scrollFadeOut / fadeScaleIn）
 ************************************************************/

import { DATA_ATTR } from '../constans/global.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数。DATA_ATTR.FEATURE は global.js）
// ---------------------------------------------------------------------------
/** 機能名（data-feature の値）。data 属性の値はキャメルケース */
const FEATURE_NAME = 'gsap';

/** モード指定用属性（data-feature-機能名-xxxx のルール） */
const ATTR_GSAP_MODE = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-mode`;

const SELECTOR_GSAP = `[${DATA_ATTR.FEATURE}="${FEATURE_NAME}"]`;

const gsap = window.gsap;
const ScrollTrigger = window.ScrollTrigger;

if (typeof gsap?.registerPlugin === 'function') {
  gsap.registerPlugin(ScrollTrigger);
}

function setupResizeRefresh() {
  let resizeTimer;
  const handleResize = () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      ScrollTrigger.refresh();
    }, 200);
  };
  window.addEventListener('resize', handleResize);
}

function initScrollFadeUp(element, options = {}) {
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

  gsap.fromTo(
    element,
    { opacity: 0, y: fromY },
    {
      opacity: 1,
      y: toY,
      duration,
      ease,
      scrollTrigger: {
        trigger: element,
        start: `top+=${startOffset} ${startPosition}`,
        scrub,
        toggleActions,
      },
    }
  );
}

function initScrollFadeIn(element, options = {}) {
  const {
    duration = 1,
    ease = 'power2.inOut',
    startOffset = 0,
    startPosition = '90%',
    scrub = false,
    toggleActions = 'play none none reverse',
  } = options;

  gsap.fromTo(
    element,
    { opacity: 0 },
    {
      opacity: 1,
      duration,
      ease,
      scrollTrigger: {
        trigger: element,
        start: `top+=${startOffset} ${startPosition}`,
        scrub,
        toggleActions,
      },
    }
  );
}

function initScrollFadeOut(element, options = {}) {
  const {
    ease = 'power1.inOut',
    startPosition = 'bottom 30%',
    endPosition = 'bottom top',
    scrub = true,
  } = options;

  gsap.to(element, {
    opacity: 0,
    ease,
    scrollTrigger: {
      trigger: element,
      start: startPosition,
      end: endPosition,
      scrub,
    },
  });
}

function initFadeScaleIn(element, options = {}) {
  const { fromScale = 0.93, toScale = 1, duration = 2, ease = 'power2.inOut' } = options;
  gsap.fromTo(
    element,
    { opacity: 0, scale: fromScale },
    { opacity: 1, scale: toScale, duration, ease }
  );
}

/**
 * 初期化（全 [data-feature="gsap"] に data-feature-gsap-mode に応じたアニメーションを適用）
 * @param {{ root?: Element }} [ctx]
 * @param {{ enableResizeRefresh?: boolean, defaultMode?: string }} [options]
 */
const init = (ctx = {}, options = {}) => {
  if (!gsap || !ScrollTrigger) return;

  const { root = document } = ctx;
  const enableResizeRefresh = options.enableResizeRefresh !== false;
  const defaultMode = options.defaultMode ?? 'scrollFadeUp';

  if (enableResizeRefresh) setupResizeRefresh();

  const elements = root.querySelectorAll(SELECTOR_GSAP);
  elements.forEach((el) => {
    const mode = el.getAttribute(ATTR_GSAP_MODE) || defaultMode;
    switch (mode) {
      case 'scrollFadeUp':
        initScrollFadeUp(el, options);
        break;
      case 'scrollFadeIn':
        initScrollFadeIn(el, options);
        break;
      case 'scrollFadeOut':
        initScrollFadeOut(el, options);
        break;
      case 'fadeScaleIn':
        initFadeScaleIn(el, options);
        break;
      default:
        console.warn(`gsap: 不明な mode "${mode}"`, el);
    }
  });
};

export const gsapModule = { init };
