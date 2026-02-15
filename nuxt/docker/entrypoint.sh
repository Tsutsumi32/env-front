#!/bin/bash
set -e
# カレント（working_dir）の .node-version に記載の Node を未インストールならインストール
if [ -f .node-version ]; then
  nodenv install -s
fi
# nodenv の shims を PATH に載せて node / npm を解決できるようにする
eval "$(nodenv init -)"
exec "$@"
