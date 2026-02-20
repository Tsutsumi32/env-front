/************************************************************
 * global グローバル定数
 ************************************************************/
// ----------------------------------------------------------
// data属性
// ----------------------------------------------------------
/**
 * 決まった命名の data 属性（data-module / data-page / data-scope / data-action）
 * - モジュールルート・ページルート・スコープ・イベントトリガーで共通利用
 */
export const DATA_ATTR = Object.freeze({
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
});

// ----------------------------------------------------------
// クラス
// ----------------------------------------------------------
/**
 * 状態変化に伴うクラス（CSS側でも使用すること。このオブジェクトから参照する）
 * - JS・CSS 双方で状態クラスはここに集約し、一貫して使用する
 */
export const STATE_CLASSES = Object.freeze({
  /** アクティブ（開いている・選択中 等） */
  ACTIVE: 'is_active',
  /** 非アクティブ（無効化） */
  DISABLED: 'is_disabled',
  /** 表示 */
  VISIBLE: 'is_visible',
  /** 非表示 */
  HIDDEN: 'is_hidden',
});

// ----------------------------------------------------------
// ブレイクポイント
// ----------------------------------------------------------
/** ブレイクポイント */
export const BREAKPOINTS = Object.freeze({
  SP: 480,
  TB: 768,
  PC: 1024,
});

// ----------------------------------------------------------
// エンドポイント
// ----------------------------------------------------------
/** エンドポイント */
export const API_ENDPOINTS = Object.freeze({
  CONTACT: '/api/contact',
  LOGIN: '/api/login',
});

// ----------------------------------------------------------
// 権限系
// 「参照の入口が複数ある」
// 「データ(value)がレコード（複数属性）」の場合
// ループして扱いたい場合(配列化)
// これらの場合には検索メソッドも用意する
// ----------------------------------------------------------
/**
 * 権限レベル定義（ここだけ編集すればOK）
 * - code: DB/APIで扱う数値
 * - id: 画面要素やテストで使う識別子
 * - label: 表示文言
 */
export const PERMISSIONS = Object.freeze({
  S: Object.freeze({ code: 1, id: "level_s", label: "レベルS" }),
  A: Object.freeze({ code: 2, id: "level_a", label: "レベルA" }),
  B: Object.freeze({ code: 3, id: "level_b", label: "レベルB" }),
  C: Object.freeze({ code: 4, id: "level_c", label: "レベルC" }),
  D: Object.freeze({ code: 5, id: "level_d", label: "レベルD" }),
  E: Object.freeze({ code: 6, id: "level_e", label: "レベルE" }),
});

/** 不正値や未定義のときに使うデフォルト */
export const DEFAULT_PERMISSION_CODE = PERMISSIONS.E.code;

/**
 * code(数値) -> メタ の逆引き辞書（自動生成）
 * 例: PERMISSION_BY_CODE[3] => { code: 3, id: "...", label: "..." }
 */
export const PERMISSION_BY_CODE = Object.freeze(
  Object.fromEntries(Object.values(PERMISSIONS).map((p) => [p.code, p]))
);

/**
 * 権限レベルのメタ情報を取得（これ1本に集約）
 * - codeが数値以外でも落ちない
 * - 未定義のcodeはDEFAULTにフォールバック
 */
export function getPermissionMeta(code) {
  if (typeof code !== "number") return PERMISSION_BY_CODE[DEFAULT_PERMISSION_CODE];
  return PERMISSION_BY_CODE[code] || PERMISSION_BY_CODE[DEFAULT_PERMISSION_CODE];
}

/** IDの取得 */
export const getPermissionLevelId = (code) => getPermissionMeta(code).id;

/** Labelの取得 */
export const getPermissionLevelLabel = (code) => getPermissionMeta(code).label;

/**
 * select/radio などUI用の一覧
 * 例: [{ value: 1, label: "レベルS" }, ...]
 */
export const PERMISSION_OPTIONS = Object.freeze(
  Object.values(PERMISSIONS).map(({ code, label }) => ({ value: code, label }))
);

/**
 * 有効な権限レベルかどうか（バリデーション用）
 */
export function isValidPermissionCode(code) {
  return typeof code === "number" && Object.prototype.hasOwnProperty.call(PERMISSION_BY_CODE, code);
}
