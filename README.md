# 環境について

## 開発環境の立ち上げ

### Dockerコンテナの起動

初回セットアップの場合は、以下のコマンドでDockerコンテナの起動とpre-commitフックの設置を行います。

```bash
make init
```

### コンテナ起動(2回目以降)

Makefileを使用してDockerコンテナを起動します。

```bash
make up
```

### 開発サーバーの起動

ビルド、ファイル監視、ブラウザシンクを同時に起動します。
*コンテナの起動も同時に行われるため、開発開始時には基本的にstartコマンドを利用します*

```bash
make dev
```

ブラウザで `http://localhost:3000` にアクセスできます。

---

## ビルドシステム

### SCSS
- **機能**: SCSSのコンパイル、minify化、PostCSS処理
- **memo**: indexまたは「_」ファイル変更時には、属するエントリーファイルをコンパイル(または全ファイル ※設定ファイルで指定可能)。エントリーファイルに属さない場合は全ファイルをコンパイル。コンパイル対象のファイル修正時には、該当ファイルのみコンパイル

### SCSSインデックス生成（common.scss）
- **機能**: SCSSファイルのエントリーポイントとなる`common.scss`を自動生成する。
- **memo**: 対象ディレクトリ内に`index.scss`がある場合: そのディレクトリの`index.scss`のみを`@use`する- **memo**:（拡張子なしで`@use './ディレクトリ名';`の形式）
ディレクトリ内のすべてのSCSSファイル（`index.scss`と`_`で始まるパーシャルファイルを除く）を`@use`する

### JavaScript
- **機能**: JSのコンパイル、minify化、ESLint

### 画像変換
- **機能**: 設定(build-config)に従って、格納したpngやjpg画像を、avif、webp変換、圧縮する
- **memo**: _originディレクトリにpngまたはjpg画像を格納します(拡張子の大文字・小文字違いや、jpg・jpeg違いなどは許容してます)
- **memo**: svgディレクトリは処理対象外です
- **memo**: Rethina対応を行う場合、基本は表示サイズの2倍の画像を用意し、変換後の画像のみを使用します。
- **memo**: `npm run meta:convert-images`でメタファイルを更新することが可能。(メタファイルを元に変換処理を行っています。メタファイルを更新すると、現時点の画像格納状態から監視を行います。)　※メタファイルにエラーが発生した場合にも本コマンドでmetaファイルを再生成することで解消可能

### ブラウザシンク
- **機能**: ブラウザシンクを起動します。基本的には本サーバーで開発を行います。

---

## プロジェクト毎の調整事項

- `build-config.js`の設定（プロジェクトの構造に合わせて調整が必要）
- JSのコンパイル有無（`package.json`）
- SCSSコンパイル方法（Live Sass Compiler / npm）
- コンパイル後の出力先（`dist`にするかどうか）
- 各種ディレクトリパス

---

## Nu Html Checker（HTML検証）

[The Nu Html Checker (vnu)](https://validator.github.io/validator/) を Docker 環境で利用できます。

### Web UI

`make up` でコンテナを起動すると、vnu サービスも起動します。ブラウザで次のURLを開くと、HTML/CSS/SVG の検証ができます。
- **URL**: `http://localhost:8888`（ポートは `.env` の `VNU_PORT` で変更可能）
- **ブックマークレット**：開発画面を開いている状態で、用意したブックマークレットを使用することで、画面内のDOMをvnuにPOSTして、そのまま検証が可能。(nu-html-checker-bookmarklet.md)

---

## コードフォーマット

### EditorConfig

- **設定ファイル**: `.editorconfig`
- **対象**: インデント、改行コード、文字コード、最終行改行、行末スペース

### Prettier

- **設定ファイル**: `.prettierrc`
- **対象**: コードの詳細なフォーマット（クォート、括弧、import順、プロパティ順など）
- **VSCode設定**: `.vscode/settings.json`でPrettierをフォーマッターに設定

### php-cs-fixer(PHPがある場合)

- **設定ファイル**: `php-cs-fixer.dist.php`

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


### ビルドができない場合

- `src`内のJSをそのまま使用
- CDNを利用する

---

## コードスニペットについて
- _docs/ にスニペットファイルを配置しています。必要に応じて活用してください。

## 規約について
- .cursor内のファイルを確認すること