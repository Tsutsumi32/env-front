/************************************************************
 * global グローバル定数
 ************************************************************/

/**
 * 状態変化に伴うクラス（CSS側でも使用すること。このオブジェクトから参照する）
 * - JS・CSS 双方で状態クラスはここに集約し、一貫して使用する
 */
export const STATE_CLASSES = {
  /** アクティブ（開いている・選択中 等） */
  ACTIVE: 'is_active',
  /** 非アクティブ（無効化） */
  DISABLED: 'is_disabled',
  /** 表示 */
  VISIBLE: 'is_visible',
  /** 非表示 */
  HIDDEN: 'is_hidden',
  /** 表示中（メニュー展開等） */
  DISPLAY: 'is-display',
};

/** ブレイクポイント */
export const BREAKPOINTS = {
  SP: 480,
  TB: 768,
  PC: 1024,
};

export const API_ENDPOINTS = {
  CONTACT: '/api/contact',
  LOGIN: '/api/login',
};
