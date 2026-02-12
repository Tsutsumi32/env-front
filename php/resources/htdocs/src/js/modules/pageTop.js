/************************************************************
 * ページトップボタン
 * - data-module="pageTop" がボタン。data-action="pageTop.scroll" でクリック時トップへ
 * - [data-pageTop-mv] を過ぎると表示（is_visible）
 ************************************************************/

import { DATA_ATTR, STATE_CLASSES } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR は global.js）
// ---------------------------------------------------------------------------
const MODULE_PAGE_TOP = 'pageTop';
const ATTR_PAGE_TOP_MV = 'data-pageTop-mv';

const SELECTOR_PAGE_TOP = `[${DATA_ATTR.MODULE}="${MODULE_PAGE_TOP}"]`;
const SELECTOR_MV = `[${ATTR_PAGE_TOP_MV}]`;

/**
 * 初期化（表示制御は [data-module="pageTop"] を参照。クリックは document に delegate、data-action="pageTop.scroll"）
 * @param {{ scope: { signal: AbortSignal } }} ctx
 * @param {{ startSelector?: string }} [options] - 表示開始の基準要素（省略時は data-pageTop-mv）
 */
const init = ({ scope }, options = {}) => {
  const pageTop = document.querySelector(SELECTOR_PAGE_TOP);
  const startEl = document.querySelector(options.startSelector || SELECTOR_MV);

  if (!pageTop) return;

  pageTop.setAttribute('aria-hidden', 'true');
  pageTop.hidden = true;

  if (startEl) {
    const observer = new IntersectionObserver(
      (entries) => {
        const [entry] = entries;
        if (!entry) return;
        const show = !entry.isIntersecting;
        if (show) {
          pageTop.removeAttribute('aria-hidden');
          pageTop.hidden = false;
          pageTop.classList.add(STATE_CLASSES.VISIBLE);
        } else {
          pageTop.classList.remove(STATE_CLASSES.VISIBLE);
          pageTop.setAttribute('aria-hidden', 'true');
          pageTop.hidden = true;
        }
      },
      { rootMargin: '0px', threshold: 0 }
    );
    observer.observe(startEl);
    scope.signal.addEventListener('abort', () => observer.disconnect(), { once: true });
  }

  delegate(document, scope, {
    'pageTop.scroll': () => window.scrollTo({ top: 0 }),
  });
};

export const pageTop = { init };
