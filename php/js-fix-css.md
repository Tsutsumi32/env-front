# ✅ JS連動UI 設計最終方針（例付き）

---

# 0. 基本原則

| 責務 | 担当 |
| --- | --- |
| 見た目・アニメーション | CSS |
| 状態付与・イベント処理 | JS |
| JS対象取得 | data属性 |
| 契約（JSと連動することの宣言） | `has-` クラス |
| 状態 | `is-` クラス |

**※ CSS では data 属性をセレクタに使わない。そのための has- クラス。** JS の要素取得は data 属性で行う。

### 🔹 ブロック部品の大前提

- **通常のスタイル**：`bl_` クラスを使用（ブロックの見た目・レイアウト）
- **has- クラス**：JS 制御で必要な**初期状態**と、`is-xxxx` が付与された場合の**状態スタイル**のみに使用
- SCSS では `/* スタイル部分 */` と `/* 状態部分 */` でコメントを入れて切り分ける

---

# 1️⃣ Module系（特定UIコンポーネント）

例：モーダル、アコーディオン、タブなど

→ **ブロック部品内で完結させる**

---

## 📁 構成

```
blocks-shared/   # ほぼ全画面で使用する block のみ（例：breadcrumbs）
blocks-feature/  # 基本的にこちらに配置（例：accordion, modal, tab, card）
  _accordion.scss
  _modal.scss
scripts/
  accordion.js
  modal.js
```

- **blocks-shared**：ほぼ全画面共通で使う block 部品だけを置く
- **blocks-feature**：それ以外の block は基本的にこちらに配置。ページごとに必要なものを `@use` で読み込む

---

## 🧱 HTML例（Accordion）

```html
<div class="bl_accordion has-accordion" data-module="accordion">
  <button class="bl_accordion_btn" data-accordion-trigger>Title</button>
  <div class="bl_accordion_panel" data-accordion-contents>Content</div>
</div>
```

---

## 🎨 SCSS例（blocks-feature/_accordion.scss）

```scss
/* ==========================================================================
  Accordion
  Contract: has-accordion, is_active（STATE_CLASSES.ACTIVE）
  JS Hooks: data-module="accordion", data-accordion-trigger, data-accordion-contents
========================================================================== */

/* =========================
   スタイル部分（bl_ で通常の見た目）
========================= */
.bl_accordion {
  background-color: ...;
  border: 1px solid ...;

  &_panel {
    overflow: hidden;
    height: 0;
    transition: height 300ms ease;
  }

  &_btn { ... }
}

/* =========================
   状態部分（has- は JS 初期状態 + is_xxx 時のスタイルのみ）
========================= */
.has-accordion.is_active {
  .bl_accordion_btnIcon {
    transform: rotate(45deg);
  }
}
```

※ height:auto問題はJSで数値制御する

---

## 🎨 SCSS例（Modal）

```scss
/* スタイル部分（bl_ で通常の見た目） */
.bl_modal {
  position: fixed;
  inset: 0;
  &_overlay { ... }
  &_dialog { ... }
  &_content { ... }
}

/* 状態部分（has- は is_active 付与時のスタイルのみ） */
.has-modal.is_active {
  pointer-events: auto;
}
```

---

## 🧠 JS例（accordion.js）

```jsx
document.querySelectorAll('[data-acc]').forEach((root) => {const btn = root.querySelector('[data-acc-btn]');const panel = root.querySelector('[data-acc-panel]');

  btn.addEventListener('click',() => {
    root.classList.toggle('is-open');
  });
});
```

---

# 2️⃣ Utils系（横断的JS処理）

例：スクロール出現アニメーション

→ **JS契約専用ディレクトリで管理**

---

## 📁 構成

```
styles/
  js-contracts/
    _scroll-in.scss
scripts/
  utils/
    scrollIn.js
```

---

## 🧱 HTML例

```html
<h2class="has-scroll-in"data-scroll-in>Title</h2><sectionclass="has-scroll-in"data-scroll-in><h3class="section__title">Heading</h3><pclass="section__lead">Text</p></section>
```

---

## 🎨 SCSS例（js-contracts/_scroll-in.scss）

Utils系は bl_ を持たず、has- のみ。`/* スタイル部分 */` = JS 初期状態、`/* 状態部分 */` = is-xxx 付与時。

```scss
/* ==========================================================================
  Scroll In
  Contract: has-scroll-in, is-inview
  JS Hook: data-scroll-in
========================================================================== */

/* スタイル部分（JS 制御で必要な初期状態） */
.has-scroll-in {
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 600ms ease, transform 600ms ease;
}

/* 状態部分（is-inview 付与時） */
.has-scroll-in.is-inview {
  opacity: 1;
  transform: translateY(0);
}
```

---

## 🧠 JS例（scrollIn.js）

```jsx
const targets =document.querySelectorAll('[data-scroll-in]');const io =newIntersectionObserver((entries) => {
  entries.forEach((entry) => {if (entry.isIntersecting) {
      entry.target.classList.add('is-inview');
      io.unobserve(entry.target);
    }
  });
});

targets.forEach((el) => io.observe(el));
```

---

# 3️⃣ 汎用アニメーションは mixin

---

## 📁 構成

```
styles/
  mixins/
    _motion.scss
```

---

## 🎨 SCSS例

```scss
@mixin fade($dur:400ms,$ease: ease) {transition: opacity$dur$ease;
}@mixin slide-up($distance:16px,$dur:400ms,$ease: ease) {transform:translateY($distance);transition: transform$dur$ease, opacity$dur$ease;
}
```

---

## 使用例

```scss
.has-scroll-in {@include slide-up(20px,600ms);opacity:0;
}.has-scroll-in.is-inview {transform:translateY(0);opacity:1;
}
```

---

# ✅ 最終ルールまとめ

### 🔹 クラス命名

- **bl_xxx**：ブロックの通常スタイル（見た目・レイアウト）
- **has-xxx**：JS 制御で必要な初期状態＋`is-xxx` 付与時の状態スタイルのみ
- **is-xxx**：状態クラス
- **data-***：JS の要素取得用。CSS では参照しない

---

### 🔹 ディレクトリ分離

| 種類 | 管理場所 |
| --- | --- |
| Module系UI（共通） | blocks-shared/（ほぼ全画面で使用する block のみ） |
| Module系UI（機能別） | blocks-feature/（accordion, modal, tab など。基本的にこちら） |
| 横断JS処理 | styles/js-contracts/ |
| アニメ型 | mixins/ |

---

### 🔹 状態付与ルール

- 原則「親に1つだけ状態クラスを付ける」
- 子の変化はCSSで制御
- JSは基本 `is-` を付けるだけ

---

# 🎯 この設計のメリット

- 「どこを見れば分かるか」が明確
- CSSとJSの責務が明確
- 横断処理が散らからない
- PRECSS思想と衝突しない
- スケールしても破綻しにくい

---

これでかなり強い設計です。