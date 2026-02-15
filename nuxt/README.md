# Nuxt 開発環境（Docker）

このリポジトリは、**複数の Nuxt プロジェクト**を扱うための Docker 開発環境です。  
Node は nodenv でバージョン管理し、MailHog・vnu を含みます。各 Nuxt アプリの構成や説明は、そのプロジェクト配下の README（例: [app/README.md](app/README.md)）を参照してください。

## 📋 要件

- Docker & Docker Compose
- Make（任意、コマンド実行に使用）

## 🚀 セットアップ

### 1. リポジトリのクローン（初回のみ）

```bash
git clone <repository-url>
cd nuxt-training-app
```

### 2. 環境変数の設定

`.env` を作成します：

```bash
cp .env-example .env
```

主な設定項目（必要に応じて編集）：

| 項目 | 説明 | デフォルト |
|------|------|------------|
| `PROJECT_NAME` | コンテナ名のプレフィックス（mailhog / vnu など） | `nuxt` |
| `CONTAINER_NAME` | Nuxt コンテナ名 | `nuxt-portfolio` |
| `WORK_DIR` | **利用する Nuxt プロジェクトのディレクトリ名**（複数プロジェクト時に切り替え） | `app` |
| `UID` / `GID` | ホストのユーザーID・グループID | `1000` |
| `HOST_PORT` / `CONTAINER_PORT` | 開発サーバーのポート | `3000` |
| `NODE_ENV` | Node の環境 | `development` |
| `MAILHOG_WEB_PORT` / `MAILHOG_SMTP_PORT` | MailHog のポート | `8025` / `1025` |
| `VNU_PORT` | vnu のポート | `8888` |

### 3. 初回セットアップ（推奨）

```bash
make init
```

- `.env` が無い場合は `.env-example` からコピー
- `docker compose up -d` でコンテナ起動
- pre-commit フックを `.git/hooks/pre-commit` に設置

### 4. 手動セットアップ

```bash
make build
# または
docker compose build
```

初回起動後、依存関係が未インストールならコンテナ内で次を実行してください：

```bash
make install
# または
docker compose exec nuxt bash -c "npm install"
```

### 5. コンテナの起動

```bash
make up          # バックグラウンド
make dev         # フォアグラウンド（ログを見ながら）
```

開発サーバー: `http://localhost:${HOST_PORT:-3000}`

## 📝 利用可能なコマンド（Makefile）

| 種類 | コマンド | 説明 |
|------|----------|------|
| 基本 | `make init` | 初回セットアップ（up + pre-commit 設置） |
| | `make build` | イメージビルド |
| | `make up` / `make down` / `make restart` | コンテナの起動・停止・再起動 |
| | `make logs` | ログ表示（-f でフォロー） |
| | `make shell` | コンテナ内シェル（working_dir は .env の WORK_DIR） |
| 開発 | `make install` | 依存関係インストール（コンテナ内） |
| | `make dev` | 開発サーバー起動（フォアグラウンド） |
| ビルド | `make generate` | 静的サイト生成（SSG）。対象は WORK_DIR のプロジェクト |
| | `make preview` | 生成サイトのプレビュー |
| 品質 | `make lint` / `make lint-fix` | ESLint |
| | `make format` / `make format-check` | Prettier |
| その他 | `make clean` | 生成物・node_modules 削除とコンテナ整理 |
| | `make help` | コマンド一覧 |

## 🏗️ この環境の構成

```
nuxt-training-app/
├── .env                   # 環境変数（.gitignore）
├── .env-example           # 環境変数のサンプル
├── docker-compose.yml     # nuxt / mailhog / vnu
├── docker/
│   ├── Dockerfile         # Ubuntu + nodenv の開発用イメージ
│   └── entrypoint.sh      # 起動時に .node-version に合わせて Node を準備
├── Makefile               # 上記コマンド（WORK_DIR 対応）
├── pre-commit             # Git フック用スクリプト
├── README.md              # このファイル（環境の説明）
└── app/                   # Nuxt プロジェクトの一例（WORK_DIR=app のときの対象）
    ├── .node-version      # このプロジェクトの Node バージョン
    └── README.md          # アプリの構成・説明
```

別の Nuxt プロジェクトを追加する場合は、ルート直下にディレクトリ（例: `app2/`）を用意し、`.env` の `WORK_DIR` で切り替えます。

## 🐳 Docker 環境について

### 前提

- プロジェクトルートに `.env` を用意する（未作成なら `.env-example` をコピーして編集）
- 各 Nuxt プロジェクトディレクトリに `.node-version` を置く（nodenv が参照）

### 構成

- **ベース**: Ubuntu 22.04（Node は **nodenv** でバージョン管理）
- **作業ディレクトリ**: `.env` の `WORK_DIR`（デフォルト: `app`）
- **補助**: MailHog（メールキャッチ）、vnu（HTML 検証）

| サービス | 用途 | URL（デフォルト） |
|----------|------|-------------------|
| nuxt | Nuxt 開発サーバー | http://localhost:3000 |
| mailhog | メールキャッチ UI | http://localhost:8025 |
| vnu | HTML 検証 | http://localhost:8888 |

- **nuxt**: `WORK_DIR` で指定したディレクトリが `working_dir`。`.node-version` に合わせて Node を利用。
- **mailhog**: メール送信のキャッチ。SMTP 1025、Web UI 8025。
- **vnu**: HTML 検証。8888。
- ボリュームはプロジェクトルートを `/var/www` にマウント。`node_modules` は各プロジェクト配下にホストと共有されるため、プロジェクトごとに独立します。

### 初回〜起動（Docker コマンドを直接使う場合）

```bash
cp .env-example .env   # 必要に応じて編集
docker compose up -d --build
docker compose exec nuxt bash -c "npm install"   # 初回のみ
docker compose logs -f nuxt
```

### Node のバージョン管理（nodenv）

- 各 Nuxt プロジェクトの**ルート**に `.node-version` を置くと、そのバージョンが使われます。
- 起動時に未インストールのバージョンは `nodenv install -s` でインストールされます。
- **注意**: `.node-version` を追加・変更したあとは `make restart` が必要です。

### プロジェクトを切り替えたい時（複数 Nuxt プロジェクト）

1. **プロジェクトを追加する**  
   例: `app2/` に Nuxt プロジェクトを配置する。
2. **`.env` の `WORK_DIR` を変更する**  
   ```env
   WORK_DIR=app2
   ```
3. **そのプロジェクトに `.node-version` を置く**  
   ```bash
   echo "22" > app2/.node-version
   ```
4. **起動し直す**  
   ```bash
   make down
   make up
   ```
5. **初回のみ**: そのプロジェクトで `make shell` してから `npm install`

#### プロジェクトごとに変えるもの

| 項目 | 説明 |
|------|------|
| **WORK_DIR** | 利用するプロジェクトのディレクトリ名（例: `app`, `app2`） |
| **Node バージョン** | 各ディレクトリの `.node-version`（nodenv が自動で使用） |

コンテナ名・ポートを変えたい場合は `.env` の `CONTAINER_NAME` / `HOST_PORT` などを変更してください。`WORK_DIR` 変更後は**必ずコンテナを再起動**してください。

### よく使うコマンド（Docker を直接使う場合）

```bash
# コンテナに入る（working_dir がカレント）
docker compose exec nuxt bash

# 別プロジェクトで npm 実行したい場合（コンテナ内）
cd /var/www/app2 && npm run dev

# 開発サーバーを止めずにコンテナだけ起動してシェルで作業
docker compose run --rm nuxt bash
```

### 本番用イメージ

現在の `docker/Dockerfile` は開発用（Ubuntu + nodenv）です。本番用は別の Dockerfile 等を用意してください。

## 🔧 トラブルシューティング

- **WORK_DIR を変えたのに反映されない** → `make restart`
- **.node-version を変えたのに反映されない** → `make restart`
- **ポート 3000 が使われている** → `.env` の `HOST_PORT` を変更して `make restart`
- **環境変数を変えた** → `make restart`
- **依存関係のエラー** → `make shell` でコンテナに入り `npm install`
- **作り直したい** → `make clean` → `make build` → `make up`

## 📚 参考

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- 各 Nuxt アプリの説明: 例として [app/README.md](app/README.md)

## 📄 ライセンス

MIT
