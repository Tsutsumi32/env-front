import { BaseModuleClass } from '../core/BaseModuleClass.js';
import { disableScroll, enableScroll } from '../utils/scrollControll.js';
import { fadeIn, fadeOut } from '../utils/fadeAnimation.js';

/**
 * ヘッダー制御クラス
 * @requires .js_header - ヘッダー要素
 * @requires .js_headerBtn - メニューボタン
 * @requires .js_headerMenu - メニュー要素
 * @requires .js_headerBg - 背景要素
 */
export class HeaderControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      headerSelector = '.js_header',
      menuBtnSelector = '.js_headerBtn',
      menuSelector = '.js_headerMenu',
      bgSelector = '.js_headerBg',
      activeClass = 'is_active',
      displayClass = 'is-display',
      openDelay = 300,
      closeDelay = 600,
    } = this.options;

    const header = document.querySelector(headerSelector);
    if (!header) {
      console.warn('ヘッダー要素が見つかりません。');
      return;
    }

    const menuBtn = header.querySelector(menuBtnSelector);
    const menu = header.querySelector(menuSelector);
    const bg = header.querySelector(bgSelector);

    if (!menu || !menuBtn || !bg) {
      console.warn('ヘッダーの必要な要素が見つかりません。');
      return;
    }

    // イベントリスナー設定
    menuBtn.addEventListener(
      'click',
      () => {
        this.toggleHeaderMenu({
          menuBtn,
          menu,
          bg,
          activeClass,
          displayClass,
          openDelay,
          closeDelay,
          signal,
          bag,
        });
      },
      { signal }
    );

    // メニュー内のリンク押下でヘッダー閉じる
    const links = menu.querySelectorAll('a');
    links.forEach((link) => {
      link.addEventListener(
        'click',
        () => {
          const timeoutId = setTimeout(() => {
            this.closeHeaderMenu({
              menuBtn,
              menu,
              bg,
              activeClass,
              displayClass,
              closeDelay,
              signal,
              bag,
            });
          }, openDelay);
          // signalでタイムアウトをクリーンアップ
          signal.addEventListener('abort', () => clearTimeout(timeoutId), { once: true });
        },
        { signal }
      );
    });
  }

  /**
   * ヘッダーメニュー開閉処理
   * @param {Object} options - 設定オプション
   * @param {AbortSignal} options.signal - AbortSignal
   * @param {Object} options.bag - disposeBag
   */
  toggleHeaderMenu(options = {}) {
    const {
      menuBtn,
      menu,
      bg,
      activeClass = 'is_active',
      displayClass = 'is-display',
      openDelay = 300,
      closeDelay = 600,
      signal,
      bag,
    } = options;

    menuBtn.style.pointerEvents = 'none';
    menuBtn.classList.toggle(activeClass);
    bg.classList.toggle(activeClass);

    if (menuBtn.classList.contains(activeClass)) {
      // 開いたときの処理
      menu.classList.toggle(displayClass);
      const timeoutId = setTimeout(() => {
        menuBtn.style.pointerEvents = 'auto';
        menu.classList.toggle(activeClass);
      }, openDelay);
      // signalでタイムアウトをクリーンアップ
      signal.addEventListener('abort', () => clearTimeout(timeoutId), { once: true });
    } else {
      menu.classList.toggle(activeClass);
      // 閉じたときの処理
      const timeoutId = setTimeout(() => {
        menuBtn.style.pointerEvents = 'auto';
        menu.classList.toggle(displayClass);
      }, closeDelay);
      // signalでタイムアウトをクリーンアップ
      signal.addEventListener('abort', () => clearTimeout(timeoutId), { once: true });
    }
  }

  /**
   * ヘッダーメニュー閉じる処理
   * @param {Object} options - 設定オプション
   * @param {AbortSignal} options.signal - AbortSignal
   * @param {Object} options.bag - disposeBag
   */
  closeHeaderMenu(options = {}) {
    const {
      menuBtn,
      menu,
      bg,
      activeClass = 'is_active',
      displayClass = 'is-display',
      closeDelay = 600,
      signal,
      bag,
    } = options;

    menuBtn.style.pointerEvents = 'none';
    menuBtn.classList.remove(activeClass);
    bg.classList.remove(activeClass);
    menu.classList.remove(activeClass);
    const timeoutId = setTimeout(() => {
      menuBtn.style.pointerEvents = 'auto';
      menu.classList.toggle(displayClass);
    }, closeDelay);
    // signalでタイムアウトをクリーンアップ
    signal.addEventListener('abort', () => clearTimeout(timeoutId), { once: true });
  }
}
