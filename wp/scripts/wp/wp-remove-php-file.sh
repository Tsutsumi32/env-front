#!/bin/bash
#===============================================
# 指定ファイル以外のテンプレートファイルを削除する
#===============================================

# 出力色
ESC=$(printf '\033')

# 現パス
path=$(cd "$(dirname "$0")/../.."; pwd)
source "${path}/.env"

wp_dir="${WP_DIR_PATH}"

# テーマ名
theme="${WP_THEME_NAME}"

# テーマディレクトリ
template_dir="${wp_dir}/wp-content/themes/${theme}" # 実際のテーマディレクトリに変更

# 削除対象外ファイル
KEEP_FILES=("index.php" "header.php" "footer.php" "functions.php" "404.php")

# 処理開始
echo "[INFO] 不要な PHP ファイルを削除します..."

# ディレクトリ内の .php ファイルをすべて確認
find "$template_dir" -maxdepth 1 -type f -name "*.php" | while read -r file; do
  filename=$(basename "$file")

  # 保持リストに含まれているか確認
  keep=false
  for keep_file in "${KEEP_FILES[@]}"; do
    if [[ "$filename" == "$keep_file" ]]; then
      keep=true
      break
    fi
  done

  # 含まれていなければ削除
  if [ "$keep" = false ]; then
    echo "[DELETE] $filename"
    rm -f "$file"
  else
    echo "[KEEP]   $filename"
  fi
done
