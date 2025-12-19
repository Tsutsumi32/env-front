.PHONY: help up down restart build rebuild logs shell start watch build-scss build-js build-convert-images meta-convert-images watch-scss watch-js watch-convert-images serve clean clean-all clean-docker install

# デフォルトターゲット
.DEFAULT_GOAL := help

# Docker Composeサービス名
SERVICE := frontend

# コンテナ内の作業ディレクトリ
WORK_DIR := /var/www/resources

##@ ヘルプ

help: ## このヘルプメッセージを表示
	@echo "利用可能なコマンド:"
	@awk 'BEGIN {FS = ":.*##"; printf "\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ Docker

up: ## Dockerコンテナを起動
	docker compose up -d

down: ## Dockerコンテナを停止
	docker compose down

restart: ## Dockerコンテナを再起動
	docker compose restart

rebuild: ## Dockerイメージを再ビルド
	docker compose build --no-cache

logs: ## Dockerコンテナのログを表示
	docker compose logs -f $(SERVICE)

shell: ## Dockerコンテナ内のシェルに接続
	docker compose exec -it $(SERVICE) bash

##@ 開発

start: up ## 開発環境を起動（ビルド + 監視 + サーバー）
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run start"

build: up ## ビルドを実行（SCSS + JS + 画像変換）
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run build"

watch: up ## ファイル監視を開始（SCSS + JS + 画像変換）
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run watch"

build-scss: up ## SCSSのみビルド
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run build:scss"

build-js: up ## JSのみビルド
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run build:js"

build-convert-images: up ## 画像変換のみビルド
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run build:convert-images"

meta-convert-images: up ## 画像変換のメタファイルを生成
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run meta:convert-images"

watch-scss: up ## SCSSの監視を開始
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run watch:scss"

watch-js: up ## JSの監視を開始
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run watch:js"

watch-convert-images: up ## 画像変換の監視を開始
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run watch:convert-images"

serve: up ## ブラウザシンクサーバーを起動
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm run serve"

##@ その他

install: up ## 依存関係をインストール
	@echo "コンテナ起動を待機中..."
	@sleep 2
	docker compose exec -it $(SERVICE) bash -c "npm install"

clean: ## ビルド成果物を削除
	@echo "ビルド成果物を削除中..."
	@rm -rf resources/htdocs/dist
	@echo "✅ クリーンアップ完了"

clean-docker: ## Dockerコンテナ、イメージ、ボリュームを完全削除
	@echo "⚠️  Dockerコンテナ、イメージ、ボリュームを完全に削除します..."
	docker compose down --rmi all --volumes --remove-orphans
	@echo "✅ Dockerの完全削除が完了しました"

clean-all: clean-docker clean ## コンテナ、イメージ、ボリューム、ビルド成果物をすべて削除
	@echo "✅ すべてのクリーンアップ完了"