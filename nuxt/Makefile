.PHONY: help init build up down restart logs shell install dev generate preview clean lint format

# .envファイルから環境変数を読み込む
-include .env
export

# デフォルト値（.env に未定義の場合のみ使用）
WORK_DIR ?= app
PROJECT_NAME ?= nuxt-portfolio
HOST_PORT ?= 3000
CONTAINER_PORT ?= 3000
PREVIEW_HOST_PORT ?= 3001
PREVIEW_CONTAINER_PORT ?= 3000

# デフォルトターゲット
help:
	@echo "利用可能なコマンド:"
	@echo "  make init       - 初回セットアップ（docker compose up -d & pre-commitフック設置）"
	@echo "  make build      - Dockerイメージをビルド"
	@echo "  make up         - コンテナを起動"
	@echo "  make down       - コンテナを停止・削除"
	@echo "  make restart    - コンテナを再起動"
	@echo "  make logs       - コンテナのログを表示"
	@echo "  make shell      - コンテナ内のシェルにアクセス"
	@echo "  make install    - 依存関係をインストール"
	@echo "  make dev        - 開発サーバーを起動 (http://localhost:$(HOST_PORT))"
	@echo "  make generate   - 静的サイトを生成（SSG）"
	@echo "  make preview    - 生成された静的サイトをプレビュー (http://localhost:$(PREVIEW_HOST_PORT))"
	@echo "  make lint       - ESLintでコードをチェック"
	@echo "  make format     - Prettierでコードを整形"
	@echo "  make clean      - 生成ファイルとnode_modulesを削除"

# 初回セットアップ（docker compose up -d & pre-commitフック設置）
# init: ## 初回セットアップ（docker compose up -d ＆ pre-commitフック設置）
# 	@if [ ! -f .env ]; then \
# 		echo "🟡 .envファイルが見つかりません。.env-exampleからコピーします..."; \
# 		cp -n .env-example .env 2>/dev/null || true; \
# 		echo "✅ .envファイルを作成しました。必要に応じて編集してください。"; \
# 	fi
# 	@echo "🟢 docker compose up -d を実行します..."
# 	docker compose up -d
# 	@echo "🟢 pre-commit フックを .git/hooks にコピーします..."
# 	@if [ ! -d .git/hooks ]; then \
# 		echo "❌ .git/hooks ディレクトリがありません。git 管理下で実行してください。"; \
# 		exit 1; \
# 	fi
# 	@cp -f pre-commit .git/hooks/pre-commit
# 	@chmod +x .git/hooks/pre-commit
# 	@echo "✅ 初期セットアップ完了: pre-commit フック設置済み"

# Dockerイメージをビルド
build:
	docker compose build

# コンテナを起動
up:
	docker compose up -d

# コンテナ起動　ビルドしなおし
up--build:
	docker compose up -d --build

# コンテナを停止・削除
down:
	docker compose down

# コンテナを再起動
restart: down up

# コンテナのログを表示
logs:
	docker compose logs -f

# コンテナ内のシェルにアクセス（.env の PROJECT_NAME でコンテナ名指定）
shell:
	docker exec -it $(PROJECT_NAME) bash

# 依存関係をインストール（コンテナが起動中ならコンテナ名で実行。docker exec では nodenv を明示的に読み込む）
install:
	docker exec $(PROJECT_NAME) bash -c 'eval "$$(nodenv init -)" && npm install'

# 開発サーバーを起動（フォアグラウンド）
dev:
	@echo "🟢 開発サーバーを起動中..."
	@echo "📍 開発サーバー: http://localhost:$(HOST_PORT)"
	docker compose up

# 静的サイトを生成（SSG）（WORK_DIR のプロジェクトで実行。コンテナが起動中であること）
generate:
	@echo "🟡 静的サイト生成前に実行中のコンテナを一時停止します..."
	@docker stop $(PROJECT_NAME) 2>/dev/null || true
	@echo "🟢 ホスト側の$(WORK_DIR)/.outputディレクトリを削除します..."
	@rm -rf $(WORK_DIR)/.output || true
	@echo "🟢 静的サイトを生成中..."
	docker compose run --rm --no-deps nuxt npm run generate
	@echo "✅ 静的サイトの生成が完了しました"

# 生成された静的サイトをプレビュー（WORK_DIR の .output を参照）
preview:
	@if [ ! -d "$(WORK_DIR)/.output" ]; then \
		echo "❌ $(WORK_DIR)/.output が見つかりません。"; \
		echo "🟡 静的サイトを生成します..."; \
		$(MAKE) generate; \
	fi
	@echo "🟢 プレビューサーバーを起動中..."
	@echo "📍 開発サーバー: http://localhost:$(HOST_PORT)"
	@echo "📍 プレビューサーバー: http://localhost:$(PREVIEW_HOST_PORT)"
	docker compose run --rm -p $(PREVIEW_HOST_PORT):$(PREVIEW_CONTAINER_PORT) nuxt npm run preview

# ESLintでコードをチェック（コンテナ名で実行）
lint:
	docker exec $(PROJECT_NAME) bash -c 'eval "$$(nodenv init -)" && npm run lint'

# ESLintでコードを自動修正
lint-fix:
	docker exec $(PROJECT_NAME) bash -c 'eval "$$(nodenv init -)" && npm run lint:fix'

# Prettierでコードを整形
format:
	docker exec $(PROJECT_NAME) bash -c 'eval "$$(nodenv init -)" && npm run format'

# Prettierでコードの整形状況をチェック
format-check:
	docker exec $(PROJECT_NAME) bash -c 'eval "$$(nodenv init -)" && npm run format:check'

# 生成ファイルとnode_modulesを削除（WORK_DIR のプロジェクト配下を対象）
clean:
	@echo "🟢 コンテナ内で生成ファイルを削除します..."
	@docker exec $(PROJECT_NAME) bash -c "rm -rf .nuxt .output dist .nitro .data .cache" 2>/dev/null || true
	@echo "🟡 コンテナを停止します..."
	@docker stop $(PROJECT_NAME) 2>/dev/null || true
	@echo "🟢 ホスト側の生成ファイルを削除します..."
	@rm -rf $(WORK_DIR)/node_modules $(WORK_DIR)/.nuxt $(WORK_DIR)/.output $(WORK_DIR)/dist $(WORK_DIR)/.nitro $(WORK_DIR)/.data $(WORK_DIR)/.cache || true
	@echo "🟢 コンテナ・ボリューム・イメージを削除します..."
	docker compose down --rmi all --volumes --remove-orphans
	@echo "✅ クリーンアップが完了しました"

