/************************************************************
 * スクロール制御
 * bodyのスクロールの制御を行う。レイアウトシフト対応済
 ************************************************************/

/** スクロール固定時にbodyに付与するクラス名（CSSで固定要素の調整に利用可能） */
export const SCROLL_LOCK_CLASS = 'is-scroll-locked';

/**
 * スクロールバー幅を計測し、:rootの--scrollbar-widthにセットする
 * @description CSSのvar(--scrollbar-width)をJSの実測値で更新する。初期表示時やリサイズ後に呼ぶとSCSSのフォールバックを上書きする。
 */
export const syncScrollbarWidth = () => {
  const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
  document.documentElement.style.setProperty('--scrollbar-width', `${scrollbarWidth}px`);
};

/**
 * スクロールを無効化し、レイアウトシフトを防ぐ
 * @param {boolean} [pl=true] - 幅調整を行うかどうか
 * @param {AbortSignal} [signal] - AbortSignal（クリーンアップ用）
 * @description スクロールバーの幅を計算し、bodyのoverflowをhiddenに設定してスクロールを無効化する。
 * スクロールバーが消えることによるレイアウトシフトを防ぐため、bodyの幅を画面幅からスクロールバー分引いた値に設定する。
 * plがtrueのとき--scrollbar-widthも実測値で更新する（fixed要素などで利用可能）。
 * 固定中はbodyにSCROLL_LOCK_CLASSが付与される。
 */
export const disableScroll = (pl = true, signal) => {
  const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
  if (pl) {
    document.documentElement.style.setProperty('--scrollbar-width', `${scrollbarWidth}px`);
    document.body.style.width = `${document.documentElement.clientWidth}px`;
  }
  document.body.style.overflow = 'hidden';
  document.body.classList.add(SCROLL_LOCK_CLASS);

  // signalがabortされたら元に戻す
  if (signal) {
    signal.addEventListener(
      'abort',
      () => {
        if (pl) {
          document.body.style.width = '';
        }
        document.body.style.overflow = 'visible';
        document.body.classList.remove(SCROLL_LOCK_CLASS);
      },
      { once: true }
    );
  }
};

/**
 * スクロールを有効化し、レイアウトを元に戻す
 * @param {boolean} [pl=true] - 幅調整を行うかどうか
 * @param {AbortSignal} [signal] - AbortSignal（クリーンアップ用、この関数では使用しないが互換性のため）
 * @description bodyのoverflowをvisibleに設定してスクロールを有効化し、
 * 設定されていた幅を解除し、SCROLL_LOCK_CLASSを外してレイアウトを元に戻す。
 */
export const enableScroll = (pl = true, signal) => {
  if (pl) {
    document.body.style.width = '';
  }
  document.body.style.overflow = 'visible';
  document.body.classList.remove(SCROLL_LOCK_CLASS);
};

/**
 * スクロールイベントを防止する内部関数
 * @param {Event} e - イベントオブジェクト
 * @private
 */
const preventScroll = (e) => {
  e.preventDefault();
};

/**
 * スクロール防止イベントリスナーを追加する
 * @param {AbortSignal} signal - AbortSignal（クリーンアップ用）
 * @description wheelとtouchmoveイベントにpreventScroll関数をバインドして、
 * マウスホイールやタッチスクロールを防止する。
 * passive: falseでイベントのデフォルト動作を阻止可能にする。
 */
export const disableScrollPrevent = (signal) => {
  document.addEventListener('wheel', preventScroll, { passive: false, signal });
  document.addEventListener('touchmove', preventScroll, { passive: false, signal });
};

/**
 * スクロール防止イベントリスナーを削除する
 * @description wheelとtouchmoveイベントからpreventScroll関数のイベントリスナーを削除して、
 * マウスホイールやタッチスクロールを再度有効化する。
 * @deprecated signalを使用したdisableScrollPreventを使用することを推奨
 */
export const enableScrollPrevent = () => {
  document.removeEventListener('wheel', preventScroll, { passive: false });
  document.removeEventListener('touchmove', preventScroll, { passive: false });
};
