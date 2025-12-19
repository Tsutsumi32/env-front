/************************************************************
 * スクロール制御
 ************************************************************/
/**
 * スクロール制御ユーティリティ関数群
 * @fileoverview ページのスクロールを制御するための関数を提供するモジュール
 * @author
 * @version 1.0.0
 */

/**
 * スクロールを無効化し、レイアウトシフトを防ぐ
 * @param {boolean} [pl=true] - パディング調整を行うかどうか
 * @param {AbortSignal} [signal] - AbortSignal（クリーンアップ用）
 * @description スクロールバーの幅を計算し、bodyのoverflowをhiddenに設定してスクロールを無効化する。
 * スクロールバーが消えることによるレイアウトシフトを防ぐため、パディングを追加する。
 */
export const disableScroll = (pl = true, signal) => {
  const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
  pl && (document.body.style.paddingRight = `${scrollbarWidth}px`);
  document.body.style.overflow = 'hidden';

  // signalがabortされたら元に戻す
  if (signal) {
    signal.addEventListener(
      'abort',
      () => {
        pl && (document.body.style.paddingRight = `0`);
        document.body.style.overflow = 'visible';
      },
      { once: true }
    );
  }
};

/**
 * スクロールを有効化し、レイアウトを元に戻す
 * @param {boolean} [pl=true] - パディング調整を行うかどうか
 * @param {AbortSignal} [signal] - AbortSignal（クリーンアップ用、この関数では使用しないが互換性のため）
 * @description bodyのoverflowをvisibleに設定してスクロールを有効化し、
 * 追加されていたパディングを削除してレイアウトを元に戻す。
 */
export const enableScroll = (pl = true, signal) => {
  pl && (document.body.style.paddingRight = `0`);
  document.body.style.overflow = 'visible';
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
