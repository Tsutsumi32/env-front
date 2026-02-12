/************************************************************
 * global グローバル定数
 ************************************************************/

/**
 * 決まった命名の data 属性（data-module / data-page / data-scope / data-action）
 * - モジュールルート・ページルート・スコープ・イベントトリガーで共通利用
 */
export const DATA_ATTR = {
  /** モジュールルート */
  MODULE: 'data-module',
  /** ページルート（body 等） */
  PAGE: 'data-page',
  /** ページ内スコープ（委譲 root） */
  SCOPE: 'data-scope',
  /** イベントトリガー（委譲対象） */
  ACTION: 'data-action',
  /** 機能の適用対象（features） */
  FEATURE: 'data-feature',
};

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
