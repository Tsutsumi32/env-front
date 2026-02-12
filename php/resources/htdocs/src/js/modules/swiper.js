/************************************************************
 * Swiper
 * - [data-module="swiper"] がスライダーコンテナ。[data-swiper-linear] でリニアモード
 * - ナビ・ページネーションは [data-swiper-parent] 内の [data-swiper-next]/[data-swiper-prev]/[data-swiper-pagination]
 ************************************************************/

import { BREAKPOINTS, DATA_ATTR } from '../constans/global.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR は global.js）
// ---------------------------------------------------------------------------
const MODULE_SWIPER = 'swiper';
const ATTR_SWIPER_LINEAR = 'data-swiper-linear';
const ATTR_SWIPER_PARENT = 'data-swiper-parent';
const ATTR_SWIPER_NEXT = 'data-swiper-next';
const ATTR_SWIPER_PREV = 'data-swiper-prev';
const ATTR_SWIPER_PAGINATION = 'data-swiper-pagination';
const ATTR_ORIGINAL = 'data-original';

const SELECTOR_ROOT = `[${DATA_ATTR.MODULE}="${MODULE_SWIPER}"]`;
const SELECTOR_SWIPER_PARENT = `[${ATTR_SWIPER_PARENT}]`;
const SELECTOR_SWIPER_NEXT = `[${ATTR_SWIPER_NEXT}]`;
const SELECTOR_SWIPER_PREV = `[${ATTR_SWIPER_PREV}]`;
const SELECTOR_SWIPER_PAGINATION = `[${ATTR_SWIPER_PAGINATION}]`;

const DATASET_KEY_ORIGINAL = 'original';

const SwiperLib = window.Swiper;
const BREAK_TAB = BREAKPOINTS.TB;
const BREAK_PC = BREAKPOINTS.PC;

export function swiperBreakPoints({ sp, tab = sp, pc = sp, ...customBreakpoints }) {
  if (!sp) throw new Error('swiperBreakPoints: "sp" is required.');
  const breakpoints = {
    0: { ...sp },
    [BREAK_TAB]: { ...tab },
    [BREAK_PC]: { ...pc },
  };
  Object.keys(customBreakpoints).forEach((key) => {
    const numKey = Number(key);
    if (!isNaN(numKey) && numKey > 0) breakpoints[numKey] = { ...customBreakpoints[key] };
  });
  return breakpoints;
}

function initNormalSlider(swiperEl, scope, options = {}) {
  if (!SwiperLib) return;
  const { signal } = scope;
  const { Navigation, Pagination, Autoplay, EffectFade } = SwiperLib;
  const classNames = {
    parent: SELECTOR_SWIPER_PARENT,
    slide: '.swiper-slide',
    wrapper: '.swiper-wrapper',
    next: SELECTOR_SWIPER_NEXT,
    prev: SELECTOR_SWIPER_PREV,
    pagination: SELECTOR_SWIPER_PAGINATION,
  };
  const { breakpoints = {}, ...swiperOptions } = options;

  const swiperParent = swiperEl.closest(classNames.parent);
  let swiperInstance = null;

  const getCurrentBreakpointOption = () => {
    const width = window.innerWidth;
    const matched = Object.keys(breakpoints)
      .map(Number)
      .sort((a, b) => b - a)
      .find((bp) => width >= bp);
    return breakpoints[matched] || {};
  };

  const initSwiperInstance = () => {
    if (swiperInstance) {
      swiperInstance.destroy(true, true);
      swiperInstance = null;
    }
    const currentOpt = getCurrentBreakpointOption();
    const slidesWrapper = swiperEl.querySelector(classNames.wrapper);
    const navNext = swiperParent?.querySelector(classNames.next);
    const navPrev = swiperParent?.querySelector(classNames.prev);
    const pagination = swiperParent?.querySelector(classNames.pagination);

    const isEnabled = currentOpt.enable !== false;
    if (!isEnabled) {
      [navNext, navPrev, pagination].forEach((el) => el && (el.style.display = 'none'));
      return;
    }

    const originalSlides = Array.from(swiperEl.querySelectorAll(classNames.slide)).filter(
      (s) => s.dataset[DATASET_KEY_ORIGINAL] === 'true'
    );
    slidesWrapper.innerHTML = '';
    originalSlides.forEach((s) => slidesWrapper.appendChild(s));

    const slideCount = originalSlides.length;
    const slidesPerView = currentOpt.slidesPerView ?? swiperOptions.slidesPerView ?? 1;
    let { loop, ...baseOptions } = swiperOptions;
    const shouldShowControls = slideCount > slidesPerView;

    if (!shouldShowControls) {
      [navNext, navPrev, pagination].forEach((el) => el && (el.style.display = 'none'));
      loop = false;
      baseOptions.centeredSlides = false;
    } else {
      if (navNext) navNext.style.display = 'block';
      if (navPrev) navPrev.style.display = 'block';
      if (pagination) pagination.style.display = 'flex';
    }

    const modules = [Navigation, Pagination, Autoplay];
    if (baseOptions.effect === 'fade' || currentOpt.effect === 'fade') modules.push(EffectFade);

    swiperInstance = new SwiperLib(swiperEl, {
      modules,
      ...baseOptions,
      ...currentOpt,
      loop,
      navigation: navNext && navPrev ? { nextEl: navNext, prevEl: navPrev } : false,
      pagination: pagination ? { el: pagination, clickable: true } : false,
    });
  };

  scope.signal.addEventListener('abort', () => {
    if (swiperInstance) swiperInstance.destroy(true, true);
  }, { once: true });

  swiperEl.querySelectorAll(classNames.slide).forEach((s) => {
    if (!s.dataset[DATASET_KEY_ORIGINAL]) s.dataset[DATASET_KEY_ORIGINAL] = 'true';
  });
  initSwiperInstance();

  let resizeTimer;
  window.addEventListener(
    'resize',
    () => {
      if (signal?.aborted) return;
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (!signal?.aborted) initSwiperInstance();
      }, 200);
      signal?.addEventListener('abort', () => clearTimeout(resizeTimer), { once: true });
    },
    { signal }
  );

}

function initLinearSlider(swiperEl, scope, options = {}) {
  if (!SwiperLib) return;
  const { signal } = scope;
  const { Autoplay } = SwiperLib;
  const { speed = 15000, allowTouchMove = false, spaceBetween = 0, slidesPerView = 'auto', breakpoints = {} } = options;
  const wrapper = swiperEl.querySelector('.swiper-wrapper');
  if (!wrapper) return;

  let swiperInstance = null;

  const getCurrentBreakpointOption = () => {
    const width = window.innerWidth;
    const matched = Object.keys(breakpoints)
      .map(Number)
      .sort((a, b) => b - a)
      .find((bp) => width >= bp);
    return breakpoints[matched] || {};
  };

  const initSwiperInstance = () => {
    if (swiperInstance) {
      swiperInstance.destroy(true, true);
      swiperInstance = null;
    }
    const currentOpt = getCurrentBreakpointOption();
    const currentSlidesPerView = currentOpt.slidesPerView ?? slidesPerView;
    const originalSlides = Array.from(swiperEl.querySelectorAll('.swiper-slide')).filter(
      (s) => s.dataset[DATASET_KEY_ORIGINAL] === 'true' || !s.dataset[DATASET_KEY_ORIGINAL]
    );
    originalSlides.forEach((s) => (s.dataset[DATASET_KEY_ORIGINAL] = 'true'));
    wrapper.innerHTML = '';
    originalSlides.forEach((s) => wrapper.appendChild(s));

    let totalSlides = originalSlides.length;
    if (typeof currentSlidesPerView === 'number') {
      const required = Math.ceil(currentSlidesPerView) * 2;
      while (totalSlides < required) {
        originalSlides.forEach((orig) => {
          const clone = orig.cloneNode(true);
          clone.dataset[DATASET_KEY_ORIGINAL] = 'false';
          wrapper.appendChild(clone);
          totalSlides++;
        });
      }
    }
    wrapper.style.transitionTimingFunction = 'linear';

    swiperInstance = new SwiperLib(swiperEl, {
      modules: [Autoplay],
      loop: true,
      slidesPerView: currentSlidesPerView,
      speed,
      allowTouchMove,
      spaceBetween,
      breakpoints,
      autoplay: { delay: 0 },
    });
  };

  scope.signal.addEventListener('abort', () => {
    if (swiperInstance) swiperInstance.destroy(true, true);
  }, { once: true });

  initSwiperInstance();

  let resizeTimer;
  window.addEventListener(
    'resize',
    () => {
      if (signal?.aborted) return;
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (!signal?.aborted) initSwiperInstance();
      }, 200);
      signal?.addEventListener('abort', () => clearTimeout(resizeTimer), { once: true });
    },
    { signal }
  );
}

/**
 * 初期化（全 [data-module="swiper"] を対象。data-swiper-linear ありならリニア、なければ通常）
 * @param {{ scope: { signal: AbortSignal }, root?: Element }} ctx
 * @param {{ normal?: object, linear?: object }} [options] - 通常/リニアのデフォルトオプション
 */
const init = ({ scope, root = document }, options = {}) => {
  if (!SwiperLib) return;

  const elements = root.querySelectorAll(SELECTOR_ROOT);
  elements.forEach((el) => {
    const isLinear = el.hasAttribute(ATTR_SWIPER_LINEAR);
    if (isLinear) initLinearSlider(el, scope, options.linear || {});
    else initNormalSlider(el, scope, options.normal || {});
  });
};

export const swiper = { init, swiperBreakPoints };
