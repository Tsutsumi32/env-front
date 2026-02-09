/**
 * ページ・コンポーネントの初期化と破棄を管理するベースクラス
 * ※還俗単純なMPAでは不要 SPAまたはViewTransitionを使用している場合など
 * AbortController + disposeBag を使用した確実なクリーンアップ
 *
 * 使用例:
 * new initClass({
 *   // ページ・モジュール毎のルート要素を指定する
 *   selector: '#page-root',
 *   init: (element, { bag, signal }) => {
 *     // イベントリスナー（signalで自動解除）
 *     window.addEventListener('resize', onResize, { signal });
 *
 *     // 手動クリーンアップが必要な処理
 *     const interval = setInterval(tick, 1000);
 *     bag.add(() => clearInterval(interval));
 *
 *     // Swiper/GSAP等のインスタンス
 *     const swiper = new Swiper('.swiper');
 *     bag.dispose(swiper, 'destroy', [true, true]);
 *   }
 * });
 */

/**
 * disposeBagの実装
 * クリーンアップ関数を管理するユーティリティ
 */
function createDisposeBag() {
  const jobs = new Set();
  return {
    /**
     * クリーンアップ関数を追加
     * @param {Function} fn - クリーンアップ関数
     * @returns {Function} - 追加された関数（チェーン可能）
     */
    add(fn) {
      if (typeof fn === 'function') jobs.add(fn);
      return fn;
    },

    /**
     * オブジェクトのメソッドを自動検出してクリーンアップに追加
     * インスタンス指定して削除するような処理を対象
     * @param {Object} obj - クリーンアップ対象のオブジェクト
     * @param {string} method - メソッド名（省略時は自動検出）
     * @param {Array} args - メソッドに渡す引数
     */
    dispose(obj, method, args = []) {
      if (!obj) return;
      const m =
        method ??
        ['revert', 'destroy', 'kill', 'disconnect', 'abort'].find(
          (k) => typeof obj[k] === 'function'
        );
      if (m && typeof obj[m] === 'function') {
        jobs.add(() => obj[m](...args));
      }
    },

    /**
     * すべてのクリーンアップを実行
     * エラーが発生しても他のクリーンアップは継続実行
     */
    flush() {
      for (const fn of jobs) {
        try {
          fn();
        } catch (e) {
          console.warn('PageComponent cleanup error:', e);
        }
      }
      jobs.clear();
    },
  };
}

export class initClass {
  constructor(options) {
    this.selector = options.selector;
    this.initFn = options.init;
    this.isInitialized = false;
    this.ctrl = null;
    this.bag = null;

    this.registerEvents();
  }

  /**
   * Astroのライフサイクルイベントに登録
   */
  registerEvents() {
    // ページ遷移前のクリーンアップ
    document.addEventListener('astro:before-swap', () => this.cleanup());

    // ページ読み込み時の初期化
    document.addEventListener('astro:page-load', () => this.initialize());
    document.addEventListener('DOMContentLoaded', () => this.initialize());
  }

  /**
   * 初期化処理
   * 要素が存在する場合のみ実行される
   */
  initialize() {
    // すでに初期化済みの場合は何もしない（重複実行を防止）
    if (this.isInitialized) return;

    const element = document.querySelector(this.selector);
    // console.log("PageComponent: element found:", element);

    // 要素が存在しない場合は早期リターン
    if (!element) return;

    // 前回分を全破棄してから開始
    this.cleanup();

    // 新しいAbortControllerとdisposeBagを作成
    this.ctrl = new AbortController();
    this.bag = createDisposeBag();

    // abort したら bag も一緒に片付く
    this.ctrl.signal.addEventListener('abort', () => this.bag.flush(), { once: true });

    // 初期化処理を実行（bagとsignalを渡す）
    this.initFn(element, {
      bag: this.bag,
      signal: this.ctrl.signal,
    });

    this.isInitialized = true;
  }

  /**
   * クリーンアップ処理
   */
  cleanup() {
    if (this.ctrl) {
      this.ctrl.abort(); // abortイベントでbag.flush()が自動実行される
    }
    // クリーンアップ後は再初期化を許可
    this.isInitialized = false;
  }
}
