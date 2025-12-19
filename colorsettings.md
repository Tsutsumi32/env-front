やりたいことの再定義（正確）

$colors に 任意個のモードがある
（default / dark / high-contrast / brand-a …）

必ず default というキーが1つ存在

default → :root

それ以外 → [data-theme="キー名"]

各モード内の色は define-color-vars() で一括定義

実装側は 何も意識しない

👉
完全に正しい設計です

前提：colors map の形（再確認）
$colors: (
  default: (
    text: (
      primary: #2B2D31,
      secondary: #585B67,
    ),
    bg: (
      base: #ffffff,
    ),
  ),
  dark: (
    text: (
      primary: #ffffff,
      secondary: #cfcfcf,
    ),
    bg: (
      base: #121212,
    ),
  ),
  high-contrast: (
    text: (
      primary: #000000,
      secondary: #000000,
    ),
    bg: (
      base: #ffff00,
    ),
  ),
);

① 既存：色を吐き出す mixin（再掲・前提）
@use 'sass:map';

@mixin define-color-vars($mode) {
  $mode-map: map.get($colors, $mode);

  @if $mode-map == null {
    @error "Unknown color mode: #{$mode}";
  }

  @each $group, $group-map in $mode-map {
    @each $name, $value in $group-map {
      --color-#{$group}-#{$name}: #{$value};
    }
  }
}

② 今回の本題：テーマ全体を生成する mixin
✔ default を :root に、それ以外を data-theme に出す
@use 'sass:map';

@mixin generate-color-themes {
  // default が存在するかチェック
  @if not map.has-key($colors, default) {
    @error "$colors must have a 'default' mode.";
  }

  // :root（default）
  :root {
    @include define-color-vars(default);
  }

  // その他のモード
  @each $mode, $_ in $colors {
    @if $mode != default {
      [data-theme="#{$mode}"] {
        @include define-color-vars($mode);
      }
    }
  }
}

③ 使用側（たった1行）
@include generate-color-themes;

④ 出力されるCSS（例）
:root {
  --color-text-primary: #2B2D31;
  --color-text-secondary: #585B67;
  --color-bg-base: #ffffff;
}

[data-theme="dark"] {
  --color-text-primary: #ffffff;
  --color-text-secondary: #cfcfcf;
  --color-bg-base: #121212;
}

[data-theme="high-contrast"] {
  --color-text-primary: #000000;
  --color-text-secondary: #000000;
  --color-bg-base: #ffff00;
}

この設計が「かなり強い」理由
① モード追加が完全にデータ駆動

$colors にキーを足すだけ

SCSSロジックは 一切変更不要

② default の意味が明確

default = 未指定時のテーマ

JSがなくても成立

SSR / 静的HTMLでも安全

③ 実装・JSとの接続が超シンプル
document.documentElement.dataset.theme = 'dark';


CSSは再ビルド不要

OS連動も簡単

よくある拡張（必要なら）
prefers-color-scheme と併用
@media (prefers-color-scheme: dark) {
  :root {
    @include define-color-vars(dark);
  }
}


（※ default を上書き）

テーマ切替禁止モード（例）
@if $mode != default and $mode != internal {

最終まとめ（超重要）

✔ モードは light / dark に限定しなくていい

✔ default を :root に割り当てるのは正解

✔ テーマ生成用 mixin は作る価値がある

✔ 設計トークン → CSS変数 → 実装API が完全分離

これはもう
「CSSテーマエンジン」を自作しているレベルです。

次に行くなら自然なのは：

theme 切替の JS 側設計

OS / user / page 単位の優先順位

color 以外（shadow / border / gradient）への展開

ですが、今の構成は 自信持ってOK です。