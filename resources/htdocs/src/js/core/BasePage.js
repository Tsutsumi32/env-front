/************************************************************
 * ページ初期化クラス
 * - ページファイルは本クラスを必ず使用する
 ************************************************************/
import { initCommon } from './initCommon.js';

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
          console.warn('BasePageClass cleanup error:', e);
        }
      }
      jobs.clear();
    },
  };
}

/**
 * ページ初期化クラス
 * DOM構築完了後に全画面共通処理とページ固有処理を実行する
 * クリーンアップ処理（disposeBagとAbortController）を提供する
 *
 * @example
 * // 基本的な使用方法
 * const page = new BasePageClass('body', ({ bag, signal }) => {
 *   // イベントリスナー（signalで自動解除）
 *   window.addEventListener('resize', onResize, { signal });
 *
 *   // 手動クリーンアップが必要な処理
 *   const interval = setInterval(tick, 1000);
 *   bag.add(() => clearInterval(interval));
 *
 *   // Swiper/GSAP等のインスタンス
 *   const swiper = new Swiper('.swiper');
 *   bag.dispose(swiper, 'destroy', [true, true]);
 * });
 *
 * // 画面破棄時にクリーンアップ
 * page.cleanup();
 */
export class BasePageClass {
  /**
   * BasePageのコンストラクタ
   * @param {string|null} selector - 対象要素のセレクター（nullの場合はbody要素を使用）
   * @param {Function|null} pageInitFunction - ページ固有の初期化処理を行うコールバック関数
   *                                          ({ bag, signal }) => void の形式で受け取る
   */
  constructor(selector = null, pageInitFunction = null) {
    this.selector = selector;
    this.pageInitFunction = pageInitFunction;
    this.ctrl = null;
    this.bag = null;

    // DOM構築完了後に初期化処理を実行
    this.waitForDOM();
  }

  /**
   * DOM構築完了を待機してから初期化処理を実行
   * @private
   */
  waitForDOM() {
    const initInstance = () => {
      this.element = this.selector ? document.querySelector(this.selector) : document.body;

      // セレクターが指定されている場合、要素が存在しない場合は処理を実行しない
      if (this.selector && !this.element) {
        console.warn(`セレクター "${this.selector}" に対応する要素が見つかりません。`);
        return;
      }

      this.init();
    };

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initInstance);
    } else {
      initInstance();
    }
  }

  /**
   * 初期化処理を実行
   * 全画面共通処理とページ固有処理を順次実行する
   * クリーンアップ処理は提供するが、初期化処理内では実行しない
   * @private
   */
  init() {
    // 新しいAbortControllerとdisposeBagを作成
    this.ctrl = new AbortController();
    this.bag = createDisposeBag();

    // abort したら bag も一緒に片付く
    this.ctrl.signal.addEventListener('abort', () => this.bag.flush(), { once: true });

    // 全画面共通の処理
    this.initCommon();

    // ページ固有の処理（bagとsignalを渡す）
    this.initPage();
  }

  /**
   * 全画面共通の初期化処理を実行
   * ヘッダー、アニメーション、画像保護などの処理を含む
   * @private
   */
  initCommon() {
    // 全画面共通で実行される処理（別ファイルから呼び出し）
    initCommon({
      bag: this.bag,
      signal: this.ctrl.signal,
    });
  }

  /**
   * ページ固有の初期化処理を実行
   * コンストラクタで渡されたコールバック関数を実行する
   * @private
   */
  initPage() {
    // ページ固有の処理（コールバック関数で実行）
    if (this.pageInitFunction && typeof this.pageInitFunction === 'function') {
      this.pageInitFunction({
        bag: this.bag,
        signal: this.ctrl.signal,
      });
    }
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
