#!/bin/bash
set -e

# 環境変数からUID/GIDを取得（デフォルト値は1000）
APPUSER_UID=${UID:-1000}
APPUSER_GID=${GID:-1000}

# /var/wwwの所有権をappuserに設定（volumesでマウントされたファイルも含む）
if [ -d /var/www ]; then
    chown -R appuser:appuser /var/www || true
fi

# Apacheを起動
exec apache2-foreground

