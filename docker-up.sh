# dockerの起動から、開発のnpmコマンドまで一括実行

#!/bin/bash
docker compose up -d
sleep 2  # コンテナが起動するまで少し待つ
# working_dirが/var/www/resourcesに設定されているため、cd不要
docker compose exec -it frontend bash -c "npm run start"