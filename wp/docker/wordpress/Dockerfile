FROM wordpress:latest

# ビルド引数（デフォルト値は1000）
ARG HOST_UID=1000
ARG HOST_GID=1000

# グループとユーザーを作成（rootで実行）
RUN groupadd -g ${HOST_GID} appuser && \
    useradd -u ${HOST_UID} -g ${HOST_GID} -m -s /bin/bash appuser && \
    echo "appuser ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

#==============================
# mailhog
#==============================
RUN curl --location --output /usr/local/bin/mhsendmail https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 && \
    chmod +x /usr/local/bin/mhsendmail

COPY mailhog.ini /usr/local/etc/php/conf.d/mailhog.ini

#==============================
# Apache
#==============================
# Apacheモジュール（mod_rewrite, mod_headers）を有効化
RUN a2enmod rewrite headers

# Apache設定ファイルを追加
ADD 000-default.conf /etc/apache2/sites-enabled/000-default.conf

#==============================
# WP-CLI
#==============================
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp \
    && wp --info

#==============================
# mysqlクライアント
#==============================
RUN apt-get update && \
apt-get install -y default-mysql-client && \
rm -rf /var/lib/apt/lists/*

# entrypointスクリプトを追加（/var/wwwの所有権を設定）
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

WORKDIR /var/www/html/htdocs/wp-dir