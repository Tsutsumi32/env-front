# 更新版：全体構成（ui/なし、モジュール1ファイル集約）

# 共通処理ファイルについて

**modules/** … 独立した UI を持つもの。1ファイルに集約。
**utils/** … 汎用的にどこからでも呼べる処理（DOM に依存しない or 汎用ヘルパ）。**features/** … モジュールでも汎用 util でもなく、直接 DOM 操作するが、


### ⑨ 状態変化に伴うクラスは `STATE_CLASSES`（global.js）から使用する
- **状態の変化（開閉・選択・表示/非表示・無効化 等）に付与するクラスは、`constans/global.js` の `STATE_CLASSES` オブジェクトから参照する**
- JS・CSS 双方で同一のクラス名を使用するため、`STATE_CLASSES` に集約する
- 使用例：`STATE_CLASSES.ACTIVE`（`is_active`）、`STATE_CLASSES.HIDDEN`（`is_hidden`）、）等
- 状態クラスを直接文字列で書かず、必ず `STATE_CLASSES` から参照すること

## イベントについて
- **イベント登録は原則 `delegate()` に統一**する（`addEventListener` を直接書くのは例外のみ）
- クリック等の操作は **必ず委譲（delegate）** する
- `document` に delegate すれば「どこからでも拾える」動作も同じ書き方で統一できる
- 委譲root：ページ固有は `data-scope` の root、モジュール固有は `data-module` の root、open トリガーが散らばるモジュール（例：modal）は **document** に delegate（ロジックはモジュール側）
- **委譲が向かないイベント**は delegate で登録しない（後述の「委譲不可」「委譲非推奨」を参照）


## 追加ルール
- requestAnimationFrameを積極的に使用して、適切な描画・アニメーションを実装する
- a11yを考慮し、escキーやtabキーの考慮を行い、キー操作だけで操作可能な状態を目指す。また、非表示用にはhiddenを付けるなど、スクリーンリーダー等の対応も考慮する。
- 参照系の値とかは、一覧化して把握しやすくするために、最初に定数定義。直接値を処理内に書かないようにすること。

