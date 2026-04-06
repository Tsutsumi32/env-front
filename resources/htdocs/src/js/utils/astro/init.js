/**
 * ページ・コンポーネントの初期化と破棄を管理するベースクラス（Astro 等で部分置換する場合向け）
 * ※純粋な MPA では通常不要。astro:before-swap で bag を flush する。
 *
 * 使用例:
 * new initClass({
 *   selector: '#page-root',
 *   init: (element, { bag }) => {
 *     window.addEventListener('resize', onResize);
 *     bag.add(() => window.removeEventListener('resize', onResize));
 *
 *     const interval = setInterval(tick, 1000);
 *     bag.add(() => clearInterval(interval));
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
    this.bag = null;

    this.registerEvents();
  }

  /**
   * Astroのライフサイクルイベントに登録
   */
  registerEvents() {
    document.addEventListener('astro:before-swap', () => this.cleanup());

    document.addEventListener('astro:page-load', () => this.initialize());
    document.addEventListener('DOMContentLoaded', () => this.initialize());
  }

  /**
   * 初期化処理
   * 要素が存在する場合のみ実行される
   */
  initialize() {
    if (this.isInitialized) return;

    const element = document.querySelector(this.selector);
    if (!element) return;

    this.cleanup();

    this.bag = createDisposeBag();

    this.initFn(element, {
      bag: this.bag,
    });

    this.isInitialized = true;
  }

  /**
   * クリーンアップ処理
   */
  cleanup() {
    if (this.bag) {
      this.bag.flush();
      this.bag = null;
    }
    this.isInitialized = false;
  }
}
