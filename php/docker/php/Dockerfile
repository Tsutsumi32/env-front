FROM php:8.1-apache

# ビルド引数（デフォルト値は1000）
ARG UID=1000
ARG GID=1000

# 必要なツールをインストール
RUN apt-get update && apt-get install -y wget curl gnupg git sudo \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# グループとユーザーを作成（rootで実行）
RUN groupadd -g ${GID} appuser && \
    useradd -u ${UID} -g ${GID} -m -s /bin/bash appuser && \
    echo "appuser ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Apacheモジュール（mod_rewrite, mod_headers）を有効化
RUN a2enmod rewrite headers

# Apache設定ファイルを追加
ADD 000-default.conf /etc/apache2/sites-enabled/000-default.conf

# 作業ディレクトリ
WORKDIR /var/www

# PHP 設定ファイルを追加
COPY mailhog.ini /usr/local/etc/php/conf.d/mailhog.ini

# MailHog 用の送信バイナリを設置
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail

# entrypointスクリプトを追加（/var/wwwの所有権を設定）
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
