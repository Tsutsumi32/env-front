# Voltaを使用するDocker環境
FROM ubuntu:22.04

# ビルド引数（デフォルト値は1000）
ARG UID=1000
ARG GID=1000

# 環境変数の設定
ENV DEBIAN_FRONTEND=noninteractive

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    curl \
    ca-certificates \
    git \
    build-essential \
    sudo \
    && rm -rf /var/lib/apt/lists/*

# グループとユーザーを作成（rootで実行）
RUN groupadd -g ${GID} appuser && \
    useradd -u ${UID} -g ${GID} -m -s /bin/bash appuser && \
    echo "appuser ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# ユーザーを切り替えてVoltaをインストール
USER appuser
ENV VOLTA_HOME=/home/appuser/.volta
ENV PATH=$VOLTA_HOME/bin:$PATH

# Voltaをインストール
RUN curl https://get.volta.sh | bash

# 作業ディレクトリを設定
WORKDIR /var/www

# package.jsonとpackage-lock.jsonを先にコピー
# （voltaがpackage.jsonのvolta設定を自動的に読み取るため）
COPY --chown=appuser:appuser resources/package*.json ./resources/

# Voltaを使用してNode.jsとnpmをインストール
# package.jsonのvolta設定から自動的にバージョンを読み取る
RUN volta install node && \
    volta install npm

# 依存関係をインストール（resourcesディレクトリで実行）
# 開発環境のためnpm installを使用
WORKDIR /var/www/resources
RUN npm install

# 作業ディレクトリを元に戻す
WORKDIR /var/www

# プロジェクトのファイルをコピー
COPY --chown=appuser:appuser . .
