/************************************************************
 * Swiper
 ************************************************************/
import { BREAKPOINTS } from '../constans/global.js';
import { BaseModuleClass } from '../core/BaseModuleClass.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化）
// ---------------------------------------------------------------------------
const ATTR_MODULE = 'data-module';
const MODULE_SWIPER = 'swiper';
const ATTR_SWIPER_LINEAR = 'data-swiper-linear';
const ATTR_SWIPER_PARENT = 'data-swiper-parent';
const ATTR_SWIPER_NEXT = 'data-swiper-next';
const ATTR_SWIPER_PREV = 'data-swiper-prev';
const ATTR_SWIPER_PAGINATION = 'data-swiper-pagination';
const ATTR_ORIGINAL = 'data-original';

const SELECTOR_SWIPER_PARENT = `[${ATTR_SWIPER_PARENT}]`;
const SELECTOR_SWIPER_NEXT = `[${ATTR_SWIPER_NEXT}]`;
const SELECTOR_SWIPER_PREV = `[${ATTR_SWIPER_PREV}]`;
const SELECTOR_SWIPER_PAGINATION = `[${ATTR_SWIPER_PAGINATION}]`;

/** dataset.original のキー（data-original 属性） */
const DATASET_KEY_ORIGINAL = 'original';

/* npm *******************************************************
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

// Swiperをグローバルに登録（後方互換のため）
window.Swiper = Swiper;
**************************************************************/

// CDN ////////////////////////////////////////////////////////
const Swiper = window.Swiper;
const { Navigation, Pagination, Autoplay, EffectFade } = Swiper;

if (!Swiper) {
  console.error('Swiper is not loaded. Please check if the CDN script is included in HTML.');
}
///////////////////////////////////////////////////////////////

const BREAK_TAB = BREAKPOINTS.TB;
const BREAK_PC = BREAKPOINTS.PC;

/**
 * ブレイクポイント設定を生成
 * @param {Object} options - 各ブレイクポイントのオプション
 * @param {Object} options.sp - スマホ用オプション
 * @param {Object} options.tab - タブレット用オプション (デフォルト: sp)
 * @param {Object} options.pc - PC用オプション (デフォルト: sp)
 * @param {Object} options[number] - カスタムブレークポイント（数値キーで指定）
 * @returns {Object} ブレイクポイント設定
 */
export function swiperBreakPoints({ sp, tab = sp, pc = sp, ...customBreakpoints }) {
  if (!sp) throw new Error('swiperBreakPoints: "sp" is required.');

  const breakpoints = {
    0: { ...sp },
    [BREAK_TAB]: { ...tab },
    [BREAK_PC]: { ...pc },
  };

  // カスタムブレークポイントを追加（数値キーのみ）
  Object.keys(customBreakpoints).forEach((key) => {
    const numKey = Number(key);
    if (!isNaN(numKey) && numKey > 0) {
      breakpoints[numKey] = { ...customBreakpoints[key] };
    }
  });

  return breakpoints;
}

/**
 * Swiper制御クラス
 * @example
 * // 通常のスライダー（data-module="swiper" がスライダーコンテナ）
 * new SwiperControl('[data-module="swiper"]', {
 *   breakpoints: swiperBreakPoints({ sp: { slidesPerView: 2 } }),
 *   speed: 600,
 * });
 *
 * // 無限ループのテキストスクロールスライダー
 * new SwiperControl('[data-module="swiper"][data-swiper-linear]', {
 *   mode: 'linear',
 *   speed: 15000,
 *   allowTouchMove: false,
 * });
 */
export class SwiperControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（Swiper要素）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const { mode = 'normal', ...options } = this.options;

    if (mode === 'linear') {
      this.initLinearSlider(element, { bag, signal }, options);
    } else {
      this.initNormalSlider(element, { bag, signal }, options);
    }
  }

  /**
   * 通常のスライダーを初期化
   * @param {HTMLElement} element - 対象要素
   * @param {Object} resources - リソース
   * @param {Object} options - Swiperオプション
   * @private
   */
  initNormalSlider(element, { bag, signal }, options) {
    const {
      classNames = {
        parent: SELECTOR_SWIPER_PARENT,
        slide: '.swiper-slide',
        wrapper: '.swiper-wrapper',
        next: SELECTOR_SWIPER_NEXT,
        prev: SELECTOR_SWIPER_PREV,
        pagination: SELECTOR_SWIPER_PAGINATION,
      },
      breakpoints = {},
      ...swiperOptions
    } = options;

    const swiperEl = element;
    const classParent = classNames.parent;
    const classSlide = classNames.slide;
    const classWrapper = classNames.wrapper;
    const classNext = classNames.next;
    const classPrev = classNames.prev;
    const classPagination = classNames.pagination;

    const swiperParent = swiperEl.closest(classParent);
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
      // 既存のインスタンス破棄
      if (swiperInstance) {
        swiperInstance.destroy(true, true);
        swiperInstance = null;
      }

      const currentOpt = getCurrentBreakpointOption();
      const slidesWrapper = swiperEl.querySelector(classWrapper);
      const navNext = swiperParent?.querySelector(classNext);
      const navPrev = swiperParent?.querySelector(classPrev);
      const pagination = swiperParent?.querySelector(classPagination);

      // enableをfalseに設定した場合は無効化(enableのデフォルトはtrue)
      const isEnabled = currentOpt.enable !== false;
      if (!isEnabled) {
        if (navNext) navNext.style.display = 'none';
        if (navPrev) navPrev.style.display = 'none';
        if (pagination) pagination.style.display = 'none';
        return;
      }

      const originalSlides = Array.from(swiperEl.querySelectorAll(classSlide)).filter(
        (slide) => slide.dataset[DATASET_KEY_ORIGINAL] === 'true'
      );

      slidesWrapper.innerHTML = '';
      originalSlides.forEach((slide) => slidesWrapper.appendChild(slide));

      const slideCount = originalSlides.length;
      const slidesPerView = currentOpt.slidesPerView || swiperOptions.slidesPerView || 1;
      let { loop, ...baseOptions } = swiperOptions;

      // centeredSlides: true　かつ loop: false　は不適合であるのでワーニングをログに出力する
      if (!loop && baseOptions.centeredSlides) {
        console.warn('WARNING: loopをしない場合、centeredSlidesは不適合です');
      }

      // centerモードかどうか
      let isCentered = !!baseOptions.centeredSlides;

      // スライド適用がされる場合true(スライド数が表示枚数より多い場合)
      // Swiperはスライド数 <= 表示数の場合、スライド化しない仕様である
      const shouldShowControls = slideCount > slidesPerView;

      if (!shouldShowControls) {
        // スライド適用外の場合
        if (navNext) navNext.style.display = 'none';
        if (navPrev) navPrev.style.display = 'none';
        if (pagination) pagination.style.display = 'none';
        // 本来スライドが適用されない枚数の場合は、loopとcenterモードをオフ(動作が不安定なため)
        loop = false;
        isCentered = false;
      } else {
        // スライド適用の場合
        if (navNext) navNext.style.display = 'block';
        if (navPrev) navPrev.style.display = 'block';
        if (pagination) pagination.style.display = 'flex';
      }

      // スライド枚数が1枚の場合、centererdSlidesがtrueだとページネーション等の動きが不安定のため、スライドが1枚の場合は強制的にcenteredSlidesをfalseにする
      if (slidesPerView === 1 && isCentered) {
        isCentered = false;
      }

      if (!isCentered) {
        baseOptions.centeredSlides = false;
      }

      // loop かつ スライド化も適用の場合は、スライド数を確認して、複製処理を行う
      if (loop) {
        let totalSlides = slideCount;
        let requiredSlides;

        if (isCentered) {
          // centerモード 表示枚数(少数切捨て) + 2(左右) + 表示枚数(不足)
          const baseCount = Math.ceil(slidesPerView);
          requiredSlides = baseCount * 2 + 2;
        } else {
          // 通常モード 表示枚数(小数切り上げ) + 表示枚数(不足)
          const baseCount = Math.ceil(slidesPerView);
          requiredSlides = baseCount * 2;
        }

        // 必要スライド数に満たない場合は複製
        while (totalSlides < requiredSlides) {
          originalSlides.forEach((orig) => {
            const clone = orig.cloneNode(true);
            clone.dataset[DATASET_KEY_ORIGINAL] = 'false';
            slidesWrapper.appendChild(clone);
            totalSlides++;
          });
        }
      }

      // effectが指定されている場合はEffectFadeモジュールを追加
      const modules = [Navigation, Pagination, Autoplay];
      if (baseOptions.effect === 'fade' || currentOpt.effect === 'fade') {
        modules.push(EffectFade);
      }

      swiperInstance = new Swiper(swiperEl, {
        modules: modules,
        ...baseOptions,
        ...currentOpt,
        loop,
        navigation:
          navNext && navPrev
            ? {
                nextEl: navNext,
                prevEl: navPrev,
              }
            : false,
        pagination: pagination
          ? {
              el: pagination,
              clickable: true,
            }
          : false,
      });

      // Swiperインスタンスをbagに登録
      bag.dispose(swiperInstance, 'destroy', [true, true]);
    };

    // スライドにdata-original属性を設定
    swiperEl.querySelectorAll(classSlide).forEach((slide) => {
      if (!slide.dataset[DATASET_KEY_ORIGINAL]) {
        slide.dataset[DATASET_KEY_ORIGINAL] = 'true';
      }
    });

    initSwiperInstance();

    // リサイズ時の処理
    let resizeTimer;
    window.addEventListener(
      'resize',
      () => {
        if (signal?.aborted) {
          return;
        }
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
          if (!signal?.aborted) {
            initSwiperInstance();
          }
        }, 200);
        // signalでタイムアウトをクリーンアップ
        if (signal) {
          signal.addEventListener('abort', () => clearTimeout(resizeTimer), { once: true });
        }
      },
      { signal }
    );
  }

  /**
   * 無限ループのテキストスクロールスライダーを初期化
   * @param {HTMLElement} element - 対象要素
   * @param {Object} resources - リソース
   * @param {Object} options - Swiperオプション
   * @private
   */
  initLinearSlider(element, { bag, signal }, options) {
    const {
      speed = 15000,
      allowTouchMove = false,
      spaceBetween = 0,
      slidesPerView = 'auto',
      breakpoints = {},
    } = options;

    const swiperEl = element;
    const wrapper = swiperEl.querySelector('.swiper-wrapper');

    if (!wrapper) {
      console.warn('swiper-wrapper要素が見つかりません。');
      return;
    }

    // 現在のブレークポイントに応じたslidesPerViewを取得
    const getCurrentBreakpointOption = () => {
      const width = window.innerWidth;
      const matched = Object.keys(breakpoints)
        .map(Number)
        .sort((a, b) => b - a)
        .find((bp) => width >= bp);
      return breakpoints[matched] || {};
    };

    const initSwiperInstance = () => {
      // 既存のインスタンス破棄
      if (swiperInstance) {
        swiperInstance.destroy(true, true);
        swiperInstance = null;
      }

      const currentOpt = getCurrentBreakpointOption();
      const currentSlidesPerView = currentOpt.slidesPerView || slidesPerView;

      // スライドにdata-original属性を設定
      const originalSlides = Array.from(swiperEl.querySelectorAll('.swiper-slide')).filter(
        (slide) => slide.dataset[DATASET_KEY_ORIGINAL] === 'true' || !slide.dataset[DATASET_KEY_ORIGINAL]
      );
      originalSlides.forEach((slide) => {
        if (!slide.dataset[DATASET_KEY_ORIGINAL]) {
          slide.dataset[DATASET_KEY_ORIGINAL] = 'true';
        }
      });

      // wrapperをクリアして元のスライドのみを配置
      wrapper.innerHTML = '';
      originalSlides.forEach((slide) => wrapper.appendChild(slide));

      const slideCount = originalSlides.length;

      // slidesPerViewが数値の場合、ループのために複製処理を行う
      if (typeof currentSlidesPerView === 'number') {
        const requiredSlides = Math.ceil(currentSlidesPerView) * 2;
        let totalSlides = slideCount;

        // 必要スライド数に満たない場合は複製
        while (totalSlides < requiredSlides) {
          originalSlides.forEach((orig) => {
            const clone = orig.cloneNode(true);
            clone.dataset[DATASET_KEY_ORIGINAL] = 'false';
            wrapper.appendChild(clone);
            totalSlides++;
          });
        }
      }

      // transition-timing-function: linear を追加
      wrapper.style.transitionTimingFunction = 'linear';

      swiperInstance = new Swiper(swiperEl, {
        modules: [Autoplay],
        loop: true,
        slidesPerView: currentSlidesPerView,
        speed: speed,
        allowTouchMove: allowTouchMove,
        spaceBetween: spaceBetween,
        breakpoints: breakpoints,
        autoplay: {
          delay: 0,
        },
      });

      // Swiperインスタンスをbagに登録
      bag.dispose(swiperInstance, 'destroy', [true, true]);
    };

    let swiperInstance = null;

    initSwiperInstance();

    // リサイズ時の処理
    let resizeTimer;
    window.addEventListener(
      'resize',
      () => {
        if (signal?.aborted) {
          return;
        }
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
          if (!signal?.aborted) {
            initSwiperInstance();
          }
        }, 200);
        // signalでタイムアウトをクリーンアップ
        if (signal) {
          signal.addEventListener('abort', () => clearTimeout(resizeTimer), { once: true });
        }
      },
      { signal }
    );
  }
}
