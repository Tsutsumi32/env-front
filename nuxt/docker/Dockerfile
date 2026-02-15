# Nuxt (Node) 開発用: Ubuntu + nodenv
FROM ubuntu:22.04

ARG UID=1000
ARG GID=1000

ENV DEBIAN_FRONTEND=noninteractive

# ビルド・nodenv 用パッケージ
RUN apt-get update && apt-get install -y \
    curl \
    ca-certificates \
    git \
    build-essential \
    sudo \
    && rm -rf /var/lib/apt/lists/*

# アプリユーザー作成（ホストの UID/GID に合わせる）
RUN groupadd -g ${GID} appuser && \
    useradd -u ${UID} -g ${GID} -m -s /bin/bash appuser && \
    echo "appuser ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

USER appuser
ENV NODENV_ROOT=/home/appuser/.nodenv
ENV PATH=$NODENV_ROOT/bin:$PATH

# nodenv + node-build を導入（.node-version でバージョン切り替え）
RUN curl -fsSL https://github.com/nodenv/nodenv-installer/raw/HEAD/bin/nodenv-installer | bash

# よく使う Node をビルド時に 1 つ入れておく（Nuxt 4 は ^20.19.0 以上を要求）
RUN nodenv install 20.20.0 && nodenv global 20.20.0

WORKDIR /var/www

# エントリポイント: 作業ディレクトリの .node-version に合わせて Node をインストールしてからコマンド実行
# ビルドコンテキストはプロジェクトルート（docker-compose の context: .）を想定
COPY --chown=root:root docker/entrypoint.sh /usr/local/bin/entrypoint.sh
USER root
RUN chmod +x /usr/local/bin/entrypoint.sh
USER appuser

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["bash"]
