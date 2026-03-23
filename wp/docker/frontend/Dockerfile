# Node 24 ベースのフロントエンドビルド環境
FROM node:24-bookworm

# ビルド引数（デフォルト値は1000）
ARG HOST_UID=1000
ARG HOST_GID=1000

# 環境変数の設定
ENV DEBIAN_FRONTEND=noninteractive

# 必要なパッケージをインストール（ネイティブモジュール用に build-essential）
RUN apt-get update && apt-get install -y \
    git \
    build-essential \
    sudo \
    && rm -rf /var/lib/apt/lists/*

# UID/GID が既存の場合は流用、なければ appuser を作成（node イメージの 1000 と衝突しない）
COPY docker/frontend/docker-setup-user.sh /tmp/setup-user.sh
RUN chmod +x /tmp/setup-user.sh && \
    HOST_UID=${HOST_UID} HOST_GID=${HOST_GID} /tmp/setup-user.sh

WORKDIR /var/www/html

# package.jsonとpackage-lock.jsonを先にコピー（レイヤーキャッシュのため）
COPY resources/package*.json ./

# 依存関係をインストール（resourcesディレクトリで実行）
#WORKDIR /var/www/html
RUN npm install

# アプリケーションを実行ユーザーで所有（compose の user: と合わせる）
RUN chown -R $(cat /tmp/appuser):$(cat /tmp/appgroup) /var/www/html
