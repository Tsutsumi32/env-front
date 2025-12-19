/************************************************************
 * モジュール基底クラス
 * - 各modulesは本クラスを継承する
 * - 初期化とクリーンアップ処理を提供する
 ************************************************************/

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
          console.warn('BaseModuleClass cleanup error:', e);
        }
      }
      jobs.clear();
    },
  };
}

/**
 * モジュール基底クラス
 * 各モジュールは本クラスを継承して、init()メソッドを実装する
 *
 * @example
 * class MyModule extends BaseModuleClass {
 *   init(element, { bag, signal }) {
 *     // イベントリスナー（signalで自動解除）
 *     element.addEventListener('click', handleClick, { signal });
 *
 *     // 手動クリーンアップが必要な処理
 *     const interval = setInterval(tick, 1000);
 *     bag.add(() => clearInterval(interval));
 *
 *     // Swiper/GSAP等のインスタンス
 *     const swiper = new Swiper('.swiper');
 *     bag.dispose(swiper, 'destroy', [true, true]);
 *   }
 * }
 *
 * // 使用例
 * const module = new MyModule('.js-module');
 * // 画面側の破棄タイミングで
 * module.cleanup();
 */
export class BaseModuleClass {
  /**
   * コンストラクタ
   * @param {string|HTMLElement} selectorOrElement - 対象要素のセレクターまたは要素
   * @param {Object} options - オプション設定
   */
  constructor(selectorOrElement, options = {}) {
    this.options = options;
    this.ctrl = null;
    this.bag = null;
    this.element = null;

    // 要素を取得
    if (typeof selectorOrElement === 'string') {
      this.selector = selectorOrElement;
      this.element = document.querySelector(selectorOrElement);
    } else if (selectorOrElement instanceof HTMLElement) {
      this.element = selectorOrElement;
      this.selector = null;
    } else {
      this.selector = null;
      this.element = null;
    }

    // 要素が存在する場合のみ初期化
    if (this.element) {
      this.initialize();
    } else if (this.selector) {
      console.warn(`BaseModuleClass: セレクター "${this.selector}" に対応する要素が見つかりません。`);
    }
  }

  /**
   * 初期化処理
   * クリーンアップ処理は提供するが、初期化処理内では実行しない
   * 各画面側で適宜クリーンアップを呼び出す想定
   * @private
   */
  initialize() {
    // 新しいAbortControllerとdisposeBagを作成
    this.ctrl = new AbortController();
    this.bag = createDisposeBag();

    // abort したら bag も一緒に片付く
    this.ctrl.signal.addEventListener('abort', () => this.bag.flush(), { once: true });

    // サブクラスのinit()メソッドを呼び出し
    this.init(this.element, {
      bag: this.bag,
      signal: this.ctrl.signal,
    });
  }

  /**
   * 初期化処理（サブクラスで実装する）
   * @param {HTMLElement} element - 対象要素
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    // サブクラスで実装する
    throw new Error('BaseModuleClass: init()メソッドはサブクラスで実装する必要があります。');
  }

  /**
   * クリーンアップ処理
   * 画面側の破棄タイミング等で呼び出す
   */
  cleanup() {
    if (this.ctrl) {
      this.ctrl.abort(); // abortイベントでbag.flush()が自動実行される
    }
  }

  /**
   * disposeBagを取得（外部からアクセス可能）
   * @returns {Object|null} disposeBag
   */
  getBag() {
    return this.bag;
  }

  /**
   * AbortSignalを取得（外部からアクセス可能）
   * @returns {AbortSignal|null} signal
   */
  getSignal() {
    return this.ctrl?.signal || null;
  }
}

