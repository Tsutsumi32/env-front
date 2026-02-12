# 更新版：全体構成（ui/なし、モジュール1ファイル集約）

※ イベント委譲・モジュールの扱い・属性の扱いは **js-fix-2.md** の方針に合わせて整理しています（data-action に統一、委譲不可/非推奨の明示、delegate の options と警告）。

## 大前提
- 実装例はあくまで例なので、既存のモジュールなどの仕様についてはそのままを維持するようにして
- 実装例にはコメントが少ないので、もう少し後から見ても分かりやすいようにコメントを入れて
- 全体的にアロー関数にして対応してください。(実装例はなっていない部分もありますが)


## windowのイベントについて
- scrollやresizeイベントは、一か所に集約して実装を行う方針にする


## イベントについて
- **イベント登録は原則 `delegate()` に統一**する（`addEventListener` を直接書くのは例外のみ）
- クリック等の操作は **必ず委譲（delegate）** する
- `document` に delegate すれば「どこからでも拾える」動作も同じ書き方で統一できる
- 委譲root：ページ固有は `data-scope` の root、モジュール固有は `data-module` の root、open トリガーが散らばるモジュール（例：modal）は **document** に delegate（ロジックはモジュール側）
- **委譲が向かないイベント**は delegate で登録しない（後述の「委譲不可」「委譲非推奨」を参照）


## ディレクトリ構成（案）

```
src/
  entry/
    user.js
    home.js
    ...# MPAならページごとが基本（動的importも可）

  common/
    initCommon.js# 全ページ共通初期化（必ず通す）
    （globalController は使用しない。各モジュールが document に delegate）

  lifecycle/
    domReady.js
    scope.js
    createPage.js
    createModule.js
    bootPage.js

  pages/
    userPage.js# export const start = createPage(...)
    homePage.js
    ...

  modules/
    modal.js# モーダルに関する処理を全部ここに集約
    toast.js# （将来）トーストも同様に1ファイル集約
    drawer.js# （将来）ドロワーも同様
    ...

  utils/delegate.js# data-actionの委譲ヘルパ等
    dom.js
    ...
```

> `modules/` は「UIモジュール」も「ページ内モジュール」も置いてOK。ただし **“そのモジュールに関する処理は1ファイルに集約”**。
> 

---

# データ属性（更新）

## 採用セット

### ① `data-page`：ページルート
- ページ種別の識別（原則 `body` に付与）

### ② `data-scope`：ページ内スコープ
- ページ内で委譲 root を分けたいときのブロック単位
- 主にレイアウト単位(section単位くらい)まで

### ③ `data-module`：モジュールルート
- モジュールの DOM 起点（ルート要素）の識別

### ④ `data-action`：イベントトリガー（委譲対象）
- **イベント登録に使う唯一の属性**
- 値は責務が分かるように **`責務.動詞`** で統一する
  - 例：`page.save` / `modal.open` / `accordion.toggle`
- ルール：`<責務>.<動詞>`（責務例：`page`, `modal`, `accordion`, `toast`, `drawer`）

### ⑤ `data-モジュール名-xxxx`：モジュール関連のデータ属性
- モジュール専用のパラメータ・識別子（例：`data-modal-id`, `data-modal-type`）

### ⑥ `data-xxxx`：その他（ページ側で参照する情報）
- ページ固有の識別や値（例：`data-id`, `data-user-id`, `data-track`）

### ⑦ 要素・値の取得に `js_` クラスは使わない
- **JS で制御する要素や値を取得する際、`js_` プレフィックスのクラスは使用しない**
- ルールに沿った **data 属性**で取得する
  - モジュールルート：`[data-module="モジュール名"]`
  - モジュール内の要素・サブ要素：`data-モジュール名-xxx`（例：`[data-modal-content]`, `[data-modal-scroll]`, `[data-accordion-trigger]`, `[data-accordion-contents]`）
  - 汎用の操作対象：`[data-theme-toggle]` など、役割が分かる data 属性を付与
- クラス名はスタイル用途（BEM 等）に限定し、JS 用のフックには data 属性を用いる

### ⑧ 状態変化に伴うクラスは `STATE_CLASSES`（global.js）から使用する
- **状態の変化（開閉・選択・表示/非表示・無効化 等）に付与するクラスは、`constans/global.js` の `STATE_CLASSES` オブジェクトから参照する**
- JS・CSS 双方で同一のクラス名を使用するため、`STATE_CLASSES` に集約する
- 使用例：`STATE_CLASSES.ACTIVE`（`is_active`）、`STATE_CLASSES.HIDDEN`（`is_hidden`）、`STATE_CLASSES.DISPLAY`（`is-display`）等
- 状態クラスを直接文字列で書かず、必ず `STATE_CLASSES` から参照すること

> **イベントトリガーは `data-action` のみ**。それ以外の `data-*` は「ただのデータ」なので自由に増やしてよい。**要素の取得も data 属性で行い、`js_` クラスは使わない。** 状態クラスは **`STATE_CLASSES`** から使用する。

---

# 委譲が向かないイベント

## A. バブリングしない（委譲不可）
delegate では基本的に動かない。**禁止（警告＋登録停止）** とする。
- `focus` / `blur`（代替：`focusin` / `focusout`）
- `mouseenter` / `mouseleave`（代替：`mouseover` / `mouseout`）
- `pointerenter` / `pointerleave`（代替：`pointerover` / `pointerout`）
- `load` / `error` / `abort`（ロード系）
- `resize`（window/要素都合）
- `scroll`（扱いが難しいためここでは NG 扱い）

## B. 高頻度・重い（委譲非推奨）
委譲は可能だが `closest()` が頻繁に走るためパフォーマンス面で避けたい。**警告のみ**。
- `mousemove` / `pointermove` / `touchmove`
- `wheel`
- `drag` / `dragover` / `drop`
- `input`
- `keydown` / `keyup`

> これらは原則「対象要素に直付け」＋ throttle/RAF 等で制御する。

---

# 全ページ共通 initCommon の位置づけ（どこ？）

## 想定場所

`src/common/initCommon.js`

## 役割

- 全ページ共通の初期化をここに集約する
- `createPage` の中から **必ず**呼ばれる（強制）
- **モジュールの初期化は行わない**。モジュール（modal 等）の init は **ページ側**で呼ぶ

### 例：initCommonがやること

- ヘッダー制御・スムースアンカー・body の no-js 削除・img 右クリック防止・main 最小高さなど **共通処理のみ**
- モジュールの `init`（例：`modal.init({ scope })`）は **各ページの init 内**で呼ぶ
- 共通Polyfill/設定
- 共通監視（必要なら）

---

# 共通UIの扱い（globalController は使用しない）

## 方針

- **各モジュールが document に delegate する運用**とする
- open トリガーが散らばるモジュール（例：modal）は、**モジュール側で `delegate(document, scope, { "modal.open": ..., "modal.close": ... })`** を実行する
- 各ページの init 内で必要なモジュールの `init({ scope })` を呼び、モジュール内で `delegate(document, scope, handlers)` により data-action を拾う（initCommon ではモジュール初期化しない）

---

# モーダルは modules/modal.js に全実装を集約

あなたの希望どおり、ここに全部入れます。

## `modules/modal.js` が持つ責務

- `initModalSystem({ scope })`
    - グローバルアクション（modal.open/close）に対応
    - モーダルroot取得（`[data-module="modal"]`）
    - open/closeの実処理
    - closeボタンや背景クリック、ESCなどのイベント登録/解除
- 必要なら `open(payload)` / `close()` を内部に持つ（外部に公開してもOK）

> 「open/closeの処理はmodulesに寄せる」＝OK。
> 
> 
> 実処理はすべて modal.js が持ち、init 内で `delegate(document, scope, ...)` により data-action を拾う。
> 

---

# 起動フロー（MPA）

## ページごとのentry

- HTMLは該当ページのentryを読み込む
- entryは `bootPage(start)` を呼ぶだけ

例：

`entry/user.js`

- `bootPage(pages/userPage.start)`

## createPage内で initCommon が必ず走る

- `createPage` が `initCommon` を呼び、ページ共通初期化が保証される

---

# 実装上の「責務の線引き」

## 共通UI（globalController は使用しない）

- 各モジュールが `init({ scope })` で `delegate(document, scope, handlers)` を実行し、data-action を拾う
- **モジュールの初期化はページ側で行う**（initCommon では行わない）。各ページの init 内で `modal.init({ scope })` 等を呼ぶ

## modules/modal.js

- やること：モーダルの仕様全部（DOM、open/close、イベント、後片付け）
- やらないこと：ページ固有の業務ロジック

# 例（挙動イメージ）

### HTML（data-action に統一）

```html
<button data-action="modal.open" data-modal-id="userEdit">編集</button>
<div data-module="modal" hidden>
  <div data-modal-content></div>
  <button data-action="modal.close">閉じる</button>
</div>
```

### イベントの拾い方

- モーダルは open トリガーが散らばるため、**モジュール側で `document` に delegate** して `modal.open` / `modal.close` を拾う
- クリックで `data-action` を拾い、`modal.open` なら open、`modal.close` なら close を実行
- ページ側はモーダルを知らなくてよい（理想形）

---

# 変更点まとめ（旧→新）

- `ui/` ディレクトリ：**廃止**
- `data-ui` / `data-global-action`：**廃止** → イベントトリガーは **`data-action` のみ**（値は `責務.動詞`）
- 共通UI：globalController は使用せず、各モジュールが document に delegate する運用
- モーダル：`modules/modal.js` に **全実装集約**
- イベント：**原則 delegate() に統一**、委譲不可イベントは登録停止・委譲非推奨は警告のみ

---

## 次にCursorへ出す改修指示を成功させるための確認（超短い）

1点だけ確認させて。

いまの `initCommon` は **既に存在**してますよね？（あなたの最初の構成にあった）

- モジュールの初期化は **ページ側**で行う（initCommon では行わない）。globalController は使用しない
- もし存在しないなら：新規作成する

※返答なしでも進められるけど、Cursor指示のパスを確定させたい意図です。

---

必要なら、次のメッセージで **この方針に沿った「最小実装コード一式（雛形）」**を全部提示します（`domReady/scope/createPage/createModule/bootPage/initCommon/modules/modal` まで。globalController は使用しない）。これをそのままCursorの修正指示に貼り付けると一気に進みます。

存在してる状態ですね。

OKです。この方針を踏まえて、もう一度全部整理したものを提供して。他の部分は良かったんで、漏れなくお願いしますね。
あと、実際の実装例をそれぞれ書いてください。

以下は、これまでの結論を **漏れなく**まとめ直した「改修指示用ドキュメント（Vanilla / MPA前提、将来SPAも見据え）」です。

※あなたの要望どおり `ui/` ディレクトリは廃止、モーダル等は `modules/` に **1ファイル集約**、共通は `initCommon` に寄せます。

※`initCommon` は **既存ファイルが存在する前提**で記載します（パスは現状に合わせて読み替えOK）。

---

# 1. ゴールと設計思想

## ゴール

- ページ/モジュールの **ライフサイクル（初期化/破棄）を統一**
- DOMイベント解除漏れを防ぐ（AbortController中心）
- ページ/モジュールを **プロジェクト横断で再利用**しやすい形にする
- MPAでも同じ運用で統一し、SPA化しても移植しやすくする

## 設計の核

- ページ/モジュールは **関数**として実装し、実行すると **cleanup関数を返す**
    - `startPage(ctx) => cleanup()`
    - `mountModule(ctx) => cleanup()`
- イベント破棄は **AbortController（signal）** を基本に統一
- signal非対応（Observer/Timer/独自購読）は `onDispose` に集約
- クリックなどの操作は **すべて `data-action`** で拾う
    - 値は `責務.動詞`（例：`modal.open`, `page.save`）
    - 委譲 root：ページ固有は `data-scope` の root、モジュールで open が散らばる場合は **document** に delegate（ロジックはモジュール側）

---

# 2. HTMLデータ属性ルール（固定）

## 採用する属性

- `data-page`：ページ識別（基本 `body` に付与）
- `data-scope`：ページ内のイベントスコープ（委譲 root）
- `data-module`：モジュール root（例：モーダルのコンテナ）
- `data-action`：**イベント登録に使う唯一の属性**。値は **`責務.動詞`** で統一（例：`page.save`, `modal.open`, `accordion.toggle`）
- `data-モジュール名-xxxx`：モジュール用パラメータ（例：`data-modal-id`）
- `data-id` 等：その他ページ側で参照する情報（自由に追加可）

## `data-action` の値ルール

**`責務.動詞`** 形式で統一

- `page.save` / `page.track`
- `modal.open` / `modal.close`
- `accordion.toggle`
- `toast.show` / `drawer.open`（将来）

---

# 3. ディレクトリ構成（ui/なし・モジュール1ファイル集約）

```
src/
  entry/
    user.js
    home.js
    ...# MPAならページごと（動的importも将来対応可）

  lifecycle/
    domReady.js
    scope.js
    createPage.js
    createModule.js
    bootPage.js

  common/
    initCommon.js# 既存（全ページ共通初期化の入口）
    （各モジュールが document に delegate。globalController は使用しない）

  pages/
    userPage.js# export const start = createPage(...)
    homePage.js
    ...

  modules/
    modal.js# モーダル関連を全部ここに集約（open/close/イベント/描画）
    toast.js# （必要になったら）同様に1ファイル集約
    drawer.js# （必要になったら）同様に1ファイル集約
    ...

  utils/delegate.js# data-action用の委譲ヘルパ
    dom.js
    ...
```

> ポイント：`modules/modal.js` に open/close など **全て実装**し、init 内で `delegate(document, scope, ...)` で data-action を拾う。globalController は使用しない。
> 

---

# 4. 起動フロー（MPA）

1. HTMLがページごとの entry を読み込む
2. entry は `bootPage(start)` を呼ぶ
3. `bootPage` は DOM構築後に start を実行し cleanup を確保
4. `createPage` の内部で **既存の `initCommon` が必ず呼ばれる**
5. 各ページの **init 内**で、そのページで使うモジュールの **init（例：modal.init）** を呼ぶ。initCommon ではモジュール初期化しない

---

# 5. 役割分担（責務の線引き）

## lifecycle/

- DOM待ち、scope生成、ページ/モジュール枠、cleanup保証
    
    → ここは「強制の仕組み」
    

## common/initCommon（既存）

- 全ページ共通初期化の入口（ヘッダー・スムースアンカー・body クラス・img 保護・main 最小高さなど）
- **モジュールの初期化は行わない**。各ページの init 内で `modal.init({ scope })` 等を呼ぶ
- 他の共通処理（polyfill、共通監視など）があればここ

## modules/modal（1ファイル集約）

- モーダルの仕様を全部ここに持つ
    - open/close
    - 背景クリック/ボタン/ESC
    - 中身差し替え（必要なら）
    - scope破棄連動

## pages/*

- ページ固有ロジック
- `data-action` はページ内の `data-scope` rootで委譲
- グローバル UI（モーダル開く等）は `data-action="modal.open"` 等にし、document で拾うかモジュールが document に delegate する。ページでは扱わない。

---

# 6. 実装例（コピペ前提の雛形）

以下は「こういう実装になる」という具体例です。

（ファイル名は上の構成想定。既存パスに合わせて調整してください）

---

## 6.1 lifecycle/domReady.js

```jsx
exportfunctiondomReady() {if (document.readyState ==="loading") {returnnewPromise((resolve) =>document.addEventListener("DOMContentLoaded", resolve, {once:true })
    );
  }returnPromise.resolve();
}
```

---

## 6.2 lifecycle/scope.js（AbortController中心）

```jsx
exportfunctioncreateScope(parentSignal) {const ac =newAbortController();if (parentSignal) {if (parentSignal.aborted) ac.abort();else parentSignal.addEventListener("abort",() => ac.abort(), {once:true });
  }constonDispose = (fn) => {
    ac.signal.addEventListener("abort", fn, {once:true });
  };return {signal: ac.signal,
    onDispose,dispose:() => ac.abort(),
  };
}
```

---

## 6.3 lifecycle/createPage.js（BasePageClass置換）

- root取得
- scope生成
- initCommon必須実行
- init実行
- cleanup返す

```jsx
import { createScope }from"./scope.js";import { initCommon }from"../common/initCommon.js";exportfunctioncreatePage({ getRoot, init }) {returnfunctionstartPage(ctx = {}) {const root = ctx.root ?? getRoot?.(ctx);if (!root)return() => {};const scope =createScope();// 全ページ共通（必ず通す）initCommon({ ...ctx, root, scope });// ページ固有
    init?.({ ...ctx, root, scope });// cleanupreturn() => scope.dispose();
  };
}
```

---

## 6.4 lifecycle/createModule.js（BaseModuleClass置換）

```jsx
import { createScope }from"./scope.js";exportfunctioncreateModule({ getRoot, mount }) {returnfunctionstartModule(ctx = {}) {const root = ctx.root ?? getRoot?.(ctx);if (!root)return() => {};const scope =createScope(ctx.scope?.signal);

    mount?.({ ...ctx, root, scope });return() => scope.dispose();
  };
}
```

---

## 6.5 lifecycle/bootPage.js（MPAの入口）

- DOM構築後にstart
- MPAでも保険として `pagehide` でcleanup

```jsx
import { domReady }from"./domReady.js";exportasyncfunctionbootPage(startPage, ctx = {}) {awaitdomReady();const cleanup =startPage({ ...ctx,document,window }) || (() => {});window.addEventListener("pagehide",() =>cleanup(), {once:true });return cleanup;
}
```

---

## 6.6 common/initCommon.js（既存に追記するイメージ）

「存在している」ので、既存処理は残します。**モジュールの初期化は行わない**（modal 等の init は各ページ側で呼ぶ）。ヘッダー制御・スムースアンカー・body クラス・img 保護・main 最小高さなど共通処理のみ。

```jsx
import { HeaderControl } from "../modules/header.js";
import { smoothAnchorLink } from "../utils/smoothAnchorLink.js";

export function initCommon({ scope }) {
  const signal = scope?.signal;
  new HeaderControl('[data-module="header"]', {});
  smoothAnchorLink(signal);
  // 既存の共通処理（no-js 削除、img 保護、main 最小高さなど）
}
```

> モジュール（modal 等）の初期化は **各ページの init 内**で行う。initCommon では呼ばない。
> 

---

## 6.7 modules/modal.js（モーダルは1ファイルに全実装）

ここが一番重要。**open/close、DOM取得、イベント、後始末まで全部**。

### HTML例（どのページにも置く）

```html
<div data-module="modal" hidden>
  <div data-modal-content></div>
  <button data-action="modal.close">閉じる</button>
</div>
```

### 実装例

- **init({ scope })** で `delegate(document, scope, { "modal.open": ..., "modal.close": ... })` を実行し、document 上の data-action を拾う（globalController は使わない）。

```jsx
import { delegate } from "../utils/delegate.js";

export function init({ scope }) {
  delegate(document, scope, {
    "modal.open": (e, el) => open({ id: el.dataset.modalId }),
    "modal.close": () => close(),
  });
}

function getModalRoot() { return document.querySelector('[data-module="modal"]'); }
function getContentEl(root) { return root.querySelector("[data-modal-content]"); }

let isInitialized = false;
function initOnce() {
  if (isInitialized) return;
  isInitialized = true;
  // 例：ESCで閉じる（必要なら）
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") close();
  });
}

function open({ id } = {}) {
  initOnce();
  const root = getModalRoot();
  if (!root) return;
  root.hidden = false;
  const content = getContentEl(root);
  if (content) content.textContent = id ? `modal id: ${id}` : "modal open";
}

function close() {
  const root = getModalRoot();
  if (!root) return;
  root.hidden = true;
  const content = getContentEl(root);
  if (content) content.textContent = "";
}
```

> さらに厳密にやるなら、modal側も内部で `AbortController` を持って「open中だけイベント登録」→ closeでabort、みたいにできます。少人数シンプル重視なら上の形でも十分。
> 

---

## 6.8 utils/delegate.js（data-action 委譲ヘルパ・推奨版）

- `root` は `document` でも `Element` でも可
- `data-action` で拾って `handlers[action]` を呼ぶ
- **委譲不可イベント**は登録自体を止める（`force: true` で例外許可）
- **委譲非推奨イベント**は日本語警告のみ（登録は続行）

```jsx
// 委譲不可：バブリングしない/扱いが特殊 → 警告＋登録停止
const 委譲不可イベント = new Set([
  "focus", "blur", "mouseenter", "mouseleave",
  "pointerenter", "pointerleave", "load", "error", "abort",
  "resize", "scroll", "DOMContentLoaded", "readystatechange",
  "unload", "beforeunload", "pagehide", "visibilitychange",
]);
// 委譲非推奨：高頻度/重い → 警告のみ
const 委譲非推奨イベント = new Set([
  "mousemove", "pointermove", "touchmove", "wheel",
  "drag", "dragover", "drop", "input", "keydown", "keyup",
]);

export const delegate = (root, scope, handlers, options = {}) => {
  const {
    eventType = "click",
    selector = "[data-action]",
    getKey = (el) => el.dataset.action,
    suppressWarn = false,
    force = false,
  } = options;
  if (!root) return;
  if (!suppressWarn) {
    if (委譲不可イベント.has(eventType)) {
      console.warn(`[delegate] 委譲不可イベント: ${eventType}`);
      if (!force) return;
    } else if (委譲非推奨イベント.has(eventType)) {
      console.warn(`[delegate] 委譲非推奨: ${eventType}`);
    }
  }
  root.addEventListener(eventType, (e) => {
    const target = e.target instanceof Element ? e.target : null;
    if (!target) return;
    const el = target.closest(selector);
    if (!el) return;
    if (root instanceof Element && !root.contains(el)) return;
    const key = getKey(el);
    const fn = handlers[key];
    if (fn) fn(e, el);
  }, { signal: scope.signal });
};
```

---

## 6.9 pages/userPage.js（ページの実装例）

- ページ識別 root（`data-scope="user"`等）を起点にする
- **そのページで使うモジュールの初期化は、この init 内で行う**（例：モーダルを使うなら `modal.init({ scope })`）
- `data-scope` が複数あれば、必要なところに delegate を貼る

### HTML例

```html
<body data-page="user">
  <main data-scope="user">
    <section data-scope="toolbar">
      <button data-action="page.save">保存</button>
      <button data-action="page.track" data-track="save_clicked">計測</button>
    </section>
    <button data-action="modal.open" data-modal-id="userEdit">編集モーダル</button>
    <section data-scope="list">
      <article data-id="101">
        <button data-action="page.select">選択</button>
      </article>
    </section>
  </main>
</body>
```

### JS例

```jsx
import { createPage } from "../lifecycle/createPage.js";
import { delegate } from "../utils/delegate.js";
import { modal } from "../modules/modal.js";

export const start = createPage({
  getRoot: () => document.querySelector('[data-scope="user"]'),
  init: ({ root, scope }) => {
    // このページで使うモジュールの初期化
    modal.init({ scope });

    const toolbar = root.querySelector('[data-scope="toolbar"]');
    const list = root.querySelector('[data-scope="list"]');
    delegate(toolbar, scope, {
      "page.save": () => { /* ページ固有の保存処理 */ },
      "page.track": (e, el) => { track(el.dataset.track); },
    });
    delegate(list, scope, {
      "page.select": (e, el) => {
        const item = el.closest("[data-id]");
        const id = item?.dataset.id;
        // id を使って処理
      },
    });
  },
});
```

> モーダルを開くボタンは `data-action="modal.open"`。ページの init 内で `modal.init({ scope })` を呼んでおけば、modal が document に delegate して data-action を拾う。initCommon ではモジュール初期化しない。
> 

---

## 6.10 entry/user.js（MPAの起動例）

```jsx
import { bootPage }from"../lifecycle/bootPage.js";import { start }from"../pages/userPage.js";bootPage(start);
```

---

# 7. rootが複数ある場合の扱い（重要な運用ルール）

## 「ページroot」は基本1つ

- ページであることの判定・DOM参照スコープの起点として1つにすると安定
- 例：`document.querySelector('[data-scope="user"]')`

## 「委譲root（data-scope）」は複数あってOK

- toolbar / list / sidebar など、ブロック単位で分割して良い
- ただし **scopeはページで1つ**にして `scope.signal` を共有 → cleanup一発

## 「同じブロックが複数」ある場合

- 一覧が多いなら「一覧root 1本で委譲して `closest('[data-id]')`」が推奨
- 少数なら各ブロックにdelegateしてもOK（click中心なら問題になりにくい）

---

# 8. Cursorでの改修作業チェックリスト（漏れ防止）

## 追加・新規作成

- `lifecycle/`：`domReady, scope, createPage, createModule, bootPage`
- `utils/delegate.js`（なければ）
- ※ `common/globalController.js` は使用しない

## 既存を活かして修正

- 各ページの init 内で、そのページで使うモジュールの init を呼ぶ（例：`modal.init({ scope })`）
    - initCommon ではモジュール初期化を行わない

## 置換

- `BasePageClass` → `createPage + bootPage` へ移行
- `BaseModuleClass` → `createModule` へ移行（必要なモジュールから順次）

## HTMLルール適用

- イベントトリガーは **`data-action` のみ**（値は `責務.動詞`：`page.save`, `modal.open` 等）
- **JS で取得する要素には `js_` クラスを使わず、data 属性**（`data-module`, `data-モジュール名-xxx` 等）を用いる
- **状態クラス**（開閉・表示等）は **`STATE_CLASSES`（global.js）** から参照する
- `data-module="modal"` を共通モーダル領域に付与
- モジュール用パラメータは `data-modal-id` 等の `data-モジュール名-xxxx` で付与

---

# 9. 運用ルール（短く）

- MPA でも entry から必ず `bootPage(start)` で起動
- ページは `start()` が cleanup を返す
- DOM イベントは `{ signal }`
- **イベントトリガーは `data-action` のみ**（値は `責務.動詞`）
- 委譲 root：ページ固有は `data-scope` の root、open が散らばるモジュールは **document** に delegate
- 委譲不可イベントは delegate で登録しない（警告＋登録停止）。委譲非推奨は警告のみ。

---

# 10. 運用メモ（イベント・属性）

- **イベントトリガーは `data-action` のみ**（実行される属性を固定）
- **要素・値の取得に `js_` クラスは使わない**。data 属性（`data-module`, `data-モジュール名-xxx` 等）を用いる
- **状態クラスは `STATE_CLASSES`（global.js）から使用**する（直接文字列で書かない）
- それ以外の `data-*` は「ただのデータ」なので自由に増やしてよい
- 委譲不可イベントを delegate で登録しようとすると **日本語警告＋登録停止**
- 委譲非推奨イベントは **日本語警告のみ**（登録は継続）