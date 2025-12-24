# フロント環境について

## 開発環境の立ち上げ

### 1. .envファイルの作成

プロジェクトルートにある`.env.example`を複製し、`.env`ファイルを作成してください。
※中身の内容についてはプロジェクト毎に指示があります。

```

### 2. Dockerコンテナの起動

初回セットアップの場合は、以下のコマンドでDockerコンテナの起動とpre-commitフックの設置を行います。

```bash
make init
```

### 3. コンテナ起動(2回目以降)

Makefileを使用してDockerコンテナを起動します。

```bash
make up
```

### 4. 開発サーバーの起動

ビルド、ファイル監視、ブラウザシンクを同時に起動します。
*コンテナの起動も同時に行われるため、開発開始時には基本的にstartコマンドを利用します*

```bash
make start
```

ブラウザで `http://localhost:3000` にアクセスできます。

---

## プロジェクト構成

```
env-front/
├── docker/              # Docker関連ファイル
│   ├── frontend/        # フロントエンド用Dockerfile
│   ├── php/             # PHP用Dockerfile
│   └── db/              # データベース関連
├── resources/           # 開発リソース
│   ├── htdocs/          # 公開ディレクトリ
│   │   ├── src/         # ソースファイル
│   │   │   ├── scss/    # SCSSファイル
│   │   │   └── js/      # JavaScriptファイル
│   │   ├── dist/        # ビルド成果物（自動生成）
│   │   └── assets/      # 静的アセット
│   │       └── images/  # 画像ファイル
│   │           ├── _origin/    # 元画像（PNG/JPG）
│   │           ├── avif/       # AVIF画像（自動生成）
│   │           ├── webp/       # WebP画像（自動生成）
│   │           ├── compression/ # 圧縮画像（自動生成）
│   │           └── svg/        # SVG画像
│   ├── node/            # Node.jsスクリプト
│   └── package.json     # npm依存関係
├── docker-compose.yml   # Docker Compose設定
├── Makefile            # Makeコマンド定義
└── .env                # 環境変数（要作成）
```

---

## Makeコマンド一覧

### Docker操作

- `make up` - Dockerコンテナを起動
- `make down` - Dockerコンテナを停止
- `make restart` - Dockerコンテナを再起動
- `make rebuild` - Dockerイメージを再ビルド
- `make logs` - Dockerコンテナのログを表示
- `make shell` - Dockerコンテナ内のシェルに接続
- `make init` - 初回セットアップ（docker compose up -d & pre-commitフック設置）

### 開発コマンド

- `make start` - 開発環境を起動（ビルド + 監視 + サーバー）
- `make build` - ビルドを実行（SCSS + JS + 画像変換）
- `make watch` - ファイル監視を開始（SCSS + JS + 画像変換）
- `make build-scss` - SCSSのみビルド
- `make build-js` - JSのみビルド
- `make build-convert-images` - 画像変換のみビルド
- `make meta-convert-images` - 画像変換のメタファイルを生成
- `make watch-scss` - SCSSの監視を開始
- `make watch-js` - JSの監視を開始
- `make watch-convert-images` - 画像変換の監視を開始
- `make serve` - ブラウザシンクサーバーを起動
- `make install` - 依存関係をインストール

### クリーンアップ

- `make clean` - ビルド成果物を削除
- `make clean-docker` - Dockerコンテナ、イメージ、ボリュームを完全削除
- `make clean-all` - コンテナ、イメージ、ボリューム、ビルド成果物をすべて削除

### ヘルプ

- `make help` - 利用可能なコマンド一覧を表示

---

## npmスクリプト

### ビルド関連

- `npm run build` - 全ビルド（SCSS + JS + 画像変換）
- `npm run build:scss` - SCSSのみビルド
- `npm run build:js` - JSのみビルド
- `npm run build:convert-images` - 画像変換のみビルド

### 監視（Watch）関連

- `npm run watch` - 全監視（SCSS + JS + 画像変換）
- `npm run watch:scss` - SCSSの監視
- `npm run watch:js` - JSの監視
- `npm run watch:convert-images` - 画像変換の監視

### 開発サーバー

- `npm run start` - ビルド + 監視 + ブラウザシンクを同時実行
- `npm run serve` - ブラウザシンクサーバーのみ起動

### 画像変換

- `npm run meta:convert-images` - 画像変換のメタファイルを生成

---

## ビルドシステム

### SCSS

- **ソースディレクトリ**: `resources/htdocs/src/scss/`
- **出力ディレクトリ**: `resources/htdocs/dist/css/`
- **機能**: SCSSのコンパイル、minify化、PostCSS処理
- **設定**: `resources/build-config.js`の`PRESERVE_DIRECTORY_STRUCTURE`で出力ディレクトリ構造を制御

### JavaScript

- **ソースディレクトリ**: `resources/htdocs/src/js/`
- **出力ディレクトリ**: `resources/htdocs/dist/js/`
- **機能**: JSのコンパイル、minify化、ESLint
- **構成**:
  - `constans/` - グローバル定数
  - `modules/` - モジュール（クラス名固定化、`initXXXX`で初期化）
  - `utils/` - ユーティリティ関数
  - `pages/` - ページ毎の処理（エントリーポイント）
  - `core/` - コア機能

### 画像変換

- **元画像ディレクトリ**: `resources/htdocs/assets/images/_origin/`
- **出力ディレクトリ**:
  - `avif/` - AVIF画像
  - `webp/` - WebP画像
  - `compression/` - 圧縮画像（PNG/JPG）
  - `svg/` - SVG画像（変換なし）

**画像の出し分け順序**:
1. AVIF
2. WebP
3. 圧縮画像（フォールバック）

**Retina対応**: 元画像は表示サイズの2倍以上のサイズを推奨

**変換防止**: `npm run meta:convert-images`でメタファイルを更新し、変換対象から除外可能

---

## ブラウザシンク

- **ポート**: `.env`の`FRONT_PORT`で設定（デフォルト: 3000）
- **プロキシモード**: `resources/build-config.js`の`BROWSER_SYNC_PROXY`で設定（デフォルト: `php:80`）
- **監視ディレクトリ**: `resources/htdocs/`

---

## コードフォーマット

### EditorConfig

- **設定ファイル**: `.editorconfig`
- **対象**: インデント、改行コード、文字コード、最終行改行、行末スペース

### Prettier

- **設定ファイル**: `.prettierrc`
- **対象**: コードの詳細なフォーマット（クォート、括弧、import順、プロパティ順など）
- **VSCode設定**: `.vscode/settings.json`でPrettierをフォーマッターに設定

### Pre-commitフック

- **ファイル**: `pre-commit`
- **機能**: コミット時にPrettierとESLintを自動実行
- **設置**: `make init`で自動設置

---

## 開発時の注意事項

### Node.jsの使用

- **ホストで使用する場合**: Voltaを使用（`package.json`の`volta`セクションを参照）
- **Dockerで使用する場合**: Dockerコンテナ内のNode.jsを使用

### クライアント都合でNode.jsが使用できない場合

1. `.vscode/settings.json`を生成（CSSのパスを設定）
2. `dist`ディレクトリを削除
3. JS: `src`内のJSをそのまま使用（コンパイルしない）
4. SCSS: Live Sass Compilerで`src`内にCSSを生成
5. ブラウザシンクは不要（Live Serverで十分）

**PHP環境の場合はDockerが必要。Live Serverは使えないため、ブラウザシンク必須**

### JSプラグインについて

- **基本方針**: npmで管理せず、CDNを利用
- **CSS**: `vendor/`ディレクトリに格納

### ビルドができない場合

- `src`内のJSをそのまま使用
- CDNを利用する

---

## 運用時の注意事項

### 外部制作で使用する場合

- 最低限のソースのみを提供
- 環境周りやJSのモジュールなどは提供しない

### プロジェクト毎の調整事項

- `build-config.js`の設定（プロジェクトの構造に合わせて調整が必要）
- JSのコンパイル有無（`package.json`）
- SCSSコンパイル方法（Live Sass Compiler / npm）
- コンパイル後の出力先（`dist`にするかどうか）
- 各種ディレクトリパス

### PHP/WPについて

- フロント環境は本環境のコンテナを使用
- PHPやWPは専用のコンテナで分離
- フロント関連のソースは常にこちらが最新であること

---

## トラブルシューティング

### image-meta.jsonがバグった場合

1. 現在の状況でメタファイルを生成: `make meta-convert-images`
2. 現在のメタ状況で変換し直し: `make build-convert-images`

### ビルド成果物のクリーンアップ

```bash
make clean
```

### Dockerの完全リセット

```bash
make clean-all
```

---

## その他

### JSの構成について

- 動的インポートはなし。各ページのファイルをエントリーにする（ない場合はcommon）
- `_es/`配下に作業用JSファイルを格納
- ESLintを使用
- Babelはレガシーブラウザ版のみで使用想定

### BasePageClass / BaseModuleClass

- `BasePageClass`: クリーンアップ処理を考慮した構成（AbortControllerを使用）
- `BaseModuleClass`: モジュール用のベースクラス（初期化とクリーンアップ）
- 各ページファイルで`BasePageClass`をインスタンス化する場合、セレクタには画面名のidを指定
- 各画面のルート要素には、画面名のidを付与すること

### Utilsについて

- 全てsignalを引数で受け取るようにする
- 画面側でutilを呼ぶときはページ側のsignal、モジュールから呼ぶときはモジュールのsignalを渡す
- 各utilsの処理では、イベント登録する場合は必ず受け取ったsignalを指定
