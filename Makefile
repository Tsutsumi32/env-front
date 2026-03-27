.PHONY: help up down restart build build-docker rebuild logs shell start watch build-scss build-js build-convert-images build-scss-index meta-convert-images watch-scss watch-js watch-convert-images watch-scss-index serve clean clean-all clean-docker install

# デフォルトターゲット
.DEFAULT_GOAL := help

# ビルド成果物（削除対象）
DIST_DIR := resources/htdocs/dist

# $(COMPOSE) コマンド（明示的に.env を渡す）
COMPOSE := docker compose --env-file .env

# .envファイルから環境変数を読み込む
ifneq (,$(wildcard .env))
    include .env
    export
endif

# $(COMPOSE)サービス名（環境変数から取得、未設定の場合はfrontendをデフォルト値として使用）
FRONT_CONTAINER := $(or $(FRONT_CONTAINER),frontend)
PHP_CONTAINER := $(or $(PHP_CONTAINER),frontend)

# プロジェクト名（環境変数から取得、未設定の場合はsample_hpをデフォルト値として使用）
PROJECT_NAME := $(or $(PROJECT_NAME),sample_hp)

# コンテナ名（環境変数から構築）
FRONT_CONTAINER_NAME := $(PROJECT_NAME)_$(FRONT_CONTAINER)
PHP_CONTAINER_NAME := $(PROJECT_NAME)_$(PHP_CONTAINER)

##@ ヘルプ

help: ## このヘルプメッセージを表示
	@echo "利用可能なコマンド:"
	@awk 'BEGIN {FS = ":.*##"; printf "\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ Docker

init: ## 初回セットアップ（.env 作成・HOST_UID/HOST_GID 反映・ビルド・起動・pre-commit フック設置）
	@if [ ! -f .env ] && [ -f .env.example ]; then \
		echo "🟡 .env が見つかりません。.env.example からコピーします..."; \
		cp .env.example .env; \
		echo "✅ .env を作成しました"; \
	fi
	@if [ ! -f docker-compose.override.yml ] && [ -f docker-compose.override.yml.example ]; then \
		printf "🍎 macユーザーですか? docker-compose.override.yml を作成します... [y(yes)/n(no)]: "; \
		read answer; \
		if [ "$$answer" = "yes" ] || [ "$$answer" = "y" ] || [ "$$answer" = "Y" ]; then \
			cp docker-compose.override.yml.example docker-compose.override.yml; \
			echo "✅ docker-compose.override.yml を作成しました"; \
		else \
			echo "⏭️ docker-compose.override.yml の作成をスキップしました"; \
		fi; \
	fi
	@sh scripts/env/update-env-uid-gid.sh 2>/dev/null || true
	@echo "🟢 Docker イメージをビルドします..."
	$(COMPOSE) build
	@echo "🟢 コンテナを起動します..."
	$(COMPOSE) up -d
	@echo "🟢 pre-commit フックを .git/hooks にコピーします..."
	@if [ ! -d .git/hooks ]; then \
		echo "❌ .git/hooks がありません。git 管理下で実行してください。"; \
		exit 1; \
	fi
	@cp -f pre-commit .git/hooks/pre-commit
	@chmod +x .git/hooks/pre-commit
	@echo "✅ 初期セットアップ完了: pre-commit フック設置済み"

build-docker: ## Docker イメージをビルド
	$(COMPOSE) build

up: ## Dockerコンテナを起動
	$(COMPOSE) up -d

down: ## Dockerコンテナを停止
	$(COMPOSE) down

restart: ## Dockerコンテナを再起動
	$(COMPOSE) restart

rebuild: ## Dockerイメージを再ビルド
	$(COMPOSE) build --no-cache

logs: ## Dockerコンテナのログを表示
	docker logs -f $(PHP_CONTAINER_NAME)

shell: ## Dockerコンテナ内のシェルに接続
	docker exec -it $(PHP_CONTAINER_NAME) bash

##@ 開発

dev: up ## 開発環境を起動（ビルド + 監視 + サーバー）
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run dev"

build: up ## ビルドを実行（SCSS + JS + 画像変換）
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run build"

watch: up ## ファイル監視を開始（SCSS + JS + 画像変換）
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run watch"

build-scss: up ## SCSSのみビルド
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run build:scss"

build-js: up ## JSのみビルド
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run build:js"

build-convert-images: up ## 画像変換のみビルド
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run build:convert-images"

build-scss-index: up ## SCSSインデックスのみビルド
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run build:scss-index"

meta-convert-images: up ## 画像変換のメタファイルを生成
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run meta:convert-images"

watch-scss: up ## SCSSの監視を開始
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run watch:scss"

watch-js: up ## JSの監視を開始
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run watch:js"

watch-convert-images: up ## 画像変換の監視を開始
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run watch:convert-images"

watch-scss-index: up ## SCSSインデックスの監視を開始
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run watch:scss-index"

serve: up ## ブラウザシンクサーバーを起動
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm run serve"


##@ その他

install: up ## 依存関係をインストール
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec -it $(FRONT_CONTAINER_NAME) bash -c "npm install"

clean: ## ビルド成果物を削除
	@echo "ビルド成果物を削除中..."
	@rm -rf $(DIST_DIR)
	@echo "✅ クリーンアップ完了"

clean-docker: ## Dockerコンテナ、イメージ、ボリュームを完全削除
	@echo "⚠️  Dockerコンテナ、イメージ、ボリュームを完全に削除します..."
	$(COMPOSE) down --rmi all --volumes --remove-orphans
	@echo "✅ Dockerの完全削除が完了しました"

clean-all: clean-docker clean ## コンテナ、イメージ、ボリューム、ビルド成果物をすべて削除
	@echo "✅ すべてのクリーンアップ完了"


php-cs-fixer-fix: up ## PHP CS Fixerで自動整形
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec $(PHP_CONTAINER_NAME) bash -lc "php-cs-fixer fix --config=/var/www/html/php-cs-fixer.dist.php"

php-cs-fixer-check: up ## PHP CS Fixerで差分確認（dry-run）
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker exec $(PHP_CONTAINER_NAME) bash -lc "php-cs-fixer fix --config=/var/www/html/php-cs-fixer.dist.php --dry-run"