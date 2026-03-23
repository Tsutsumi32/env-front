FROM wordpress:latest

#==============================
# mailhog
#==============================
RUN curl --location --output /usr/local/bin/mhsendmail https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 && \
    chmod +x /usr/local/bin/mhsendmail

COPY mailhog.ini /usr/local/etc/php/conf.d/mailhog.ini

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

WORKDIR /var/www/html/wp-dir