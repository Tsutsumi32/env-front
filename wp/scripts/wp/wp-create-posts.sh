#!/bin/bash
#===============================================
# 投稿のサンプル記事を生成する
# ----------------------------------------------
# テーマ内のPostクラスの情報に基づいて生成する
# 関連するテーマファイルの作成も行う
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

POST_DATE="2026-03-01"

#=======================================================
# Postクラスから定義情報をBash配列で読み込む
#=======================================================
export_script="${wp_dir}/wp-content/themes/${theme}/inc/utils/export-posts-for-wp-cli.php"
php "$export_script"
eval "$(php "$export_script")"


#==============================
# ターム作成関数
#==============================
function createTerm() {
    local taxonomy="$1"
    local name="$2"
    local slug="$3"
    local desc="$4"
    local order="$5"

    # 一旦作成を試みて、戻り値から ID を無視して slug をそのまま返す
    wp term create "$taxonomy" "$name" --slug="$slug" --description="$desc" --allow-root > /dev/null 2>&1

    # term_id を取得
    term_id=$(wp term list "$taxonomy" --slug="$slug" --field=term_id --format=ids --allow-root)

    # 順番が存在するなら term meta に保存（出力を抑制）
    if [[ -n "$order" && -n "$term_id" ]]; then
        wp term meta update "$term_id" "order" "$order" --allow-root > /dev/null 2>&1
    fi

    # すでに存在していてもいいので slug をそのまま返す
    echo "$slug"
}

#==============================
# 記事作成用関数
#==============================
function createPost() {
    local count="$1"
    local post_type="$2"
    local prefix="$3"
    local taxonomy="$4"
    local term_slug="$5"
    local acf_key="$6"

    # ACFファイルのパス
    local acf_path="${wp_dir}/wp-content/themes/${WP_THEME_NAME}/inc/plugins/acf/set-acf-fields.php"

    for i in $(seq 1 "$count"); do
        POST_DATE=$(date -d "${POST_DATE} +1 day" '+%Y-%m-%d')
        POST_ID=$(wp post create --post_type="$post_type" --from-post="$POST_ID_INTERFACE" \
            --post_title="${i}${prefix}タイトルタイトル${i}${prefix}タイトルタイトル${i}${prefix}タイトルタイトル" \
            --post_content="${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容${i}${prefix}内容" \
            --post_date="$POST_DATE" --post_status=publish --porcelain --allow-root)

        if [ -n "$taxonomy" ]; then
            wp post term set "$POST_ID" "$taxonomy" "$term_slug" --allow-root
        fi

        # ACFファイルが存在すれば実行
        if [ -f "$acf_path" ]; then
            wp eval-file "$acf_path" "$POST_ID" "$post_type" --allow-root
        fi

        echo "投稿を作成しました。： $POST_ID"
    done
}

#==============================
# 投稿タイプ処理対象リスト
#==============================
# 初期化
POST_TYPES_KEYS=()

#アイキャッチ画像インポート&設定
echo "${ESC}[1;32mメディアに画像をアップロードします・・・・・${ESC}[m"
wp media import "${wp_dir}/wp-content/themes/$theme/assets/images/sample01.jpg "--post_id=$POST_ID_INTERFACE --featured_image --allow-root

# コピー用
echo "${ESC}[1;32mコピー用の投稿を生成します・・・・・${ESC}[m"
POST_ID_INTERFACE=$(wp post create --post_type=information --post_title="テンプレ" --post_content="" --post_date="2024-04-01" --post_status=publish --porcelain --allow-root)

for k in "${!POST_TYPES[@]}"; do
  # アンダースコア区切りの先頭部分だけ取り出す
  type="${k%%_*}"

  # 無効または空キーをスキップ
  if [[ -z "$type" ]]; then
    continue
  fi

  # すでに含まれていない場合だけ追加（重複防止）
  if [[ ! " ${POST_TYPES_KEYS[*]} " =~ " ${type} " ]]; then
    POST_TYPES_KEYS+=("$type")
  fi
done

echo "=== 投稿タイプ一覧 ==="
for key in "${POST_TYPES_KEYS[@]}"; do
  echo "- $key"
done

for POST_KEY in "${POST_TYPES_KEYS[@]}"; do
    echo "== 投稿タイプ: $POST_KEY =="

    key_prefix=$(echo "$POST_KEY" | sed 's/\./_/g')  # ドットが含まれる場合も対応
    POST_SLUG="${POST_TYPES[${key_prefix}_slug]}"
    POST_LABEL="${POST_TYPES[${key_prefix}_label]}"
    POST_CAT="${POST_TYPES[${key_prefix}_category_slug]}"

    if [[ -n "$POST_CAT" ]]; then
      echo "[INFO] カテゴリ '$POST_CAT' の既存タームを削除中..."
      wp term list "$POST_CAT" --format=ids --allow-root | xargs -r wp term delete "$POST_CAT" --allow-root
    fi

    # タームキー自動抽出（POST_TYPES配列から動的に取得）
    TERM_KEYS=()
    for key in "${!POST_TYPES[@]}"; do
        if [[ $key == "$POST_KEY""_term_"*"_slug" ]]; then
            suffix="${key##*_term_}"
            suffix="${suffix%%_slug}"
            TERM_KEYS+=("$suffix")
        fi
    done

    declare -A TERM_SLUGS TERM_LABELS

    if [[ -n "$TERM_KEYS" ]]; then
      echo "${ESC}[1;32mカテゴリの生成を行います・・・・・${ESC}[m"
      for key in "${TERM_KEYS[@]}"; do
          slug="${POST_TYPES["$POST_KEY""_term_""$key""_slug"]}"
          label="${POST_TYPES["$POST_KEY""_term_""$key""_label"]}"
          order="${POST_TYPES["$POST_KEY""_term_""$key""_order"]}"
          TERM_SLUGS[$key]=$(createTerm "$POST_CAT" "$label" "$slug" "$label" "$order")
          TERM_LABELS[$key]="$label"
          echo "カテゴリ：$slug を作成しました。"
      done
    else
      echo "カテゴリはありません。"
    fi

    # 既存投稿削除
    echo "${ESC}[1;32m既存の投稿をすべて削除します・・・・・${ESC}[m"
    wp post delete $(wp post list --post_type="$POST_SLUG" --format=ids --allow-root) --force --allow-root

    echo "${ESC}[1;32m投稿の生成を行います・・・・・${ESC}[m"
    if [[ -n "$key" && -n "${TERM_SLUGS[$key]}" ]]; then
        # カテゴリがある場合はカテゴリの種類ごとに作成
        for key in "${TERM_KEYS[@]}"; do
          createPost 5 "$POST_SLUG" "$POST_LABEL" "$POST_CAT" "${TERM_SLUGS[$key]}" "$POST_SLUG"
        done
    else
      # カテゴリがない投稿
      createPost 20 "$POST_SLUG" "$POST_LABEL" "$POST_CAT" "" "$POST_SLUG"
    fi
done

# テンプレート投稿削除・作成
wp post delete "$POST_ID_INTERFACE" --force --allow-root


#########################################################
# php ファイル生成
#########################################################
echo "${ESC}[1;32mphpファイルの生成を行います・・・・・${ESC}[m"

# テンプレートを生成する関数
generate_template() {
  local file_path="$1"
  local content="$2"

  if [ -f "$file_path" ]; then
    echo "[SKIP] $file_path はすでに存在します。"
  else
    echo "[CREATE] $file_path を生成します。"
    echo "$content" > "$file_path"
  fi
}

# 投稿タイプごとに処理
for type in "${POST_TYPES_KEYS[@]}"; do
  archive_file="${template_dir}/archive-${type}.php"
  single_file="${template_dir}/single-${type}.php"
  taxonomy_file="${template_dir}/taxonomy-${type}-category.php"

  has_archive_key="${type}_has_archive"
  if [[ -n "${POST_TYPES[$has_archive_key]}" ]]; then
    # archive-{type}.php
    generate_template "$archive_file" "<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class=\"ly_main\">
    ※ ${type} archive
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>"

    # taxonomy-{type}-category.php（{type}_category_slug が存在する場合）
    cat_slug_key="${type}_category_slug"
    if [[ -n "${POST_TYPES[$cat_slug_key]}" ]]; then
      generate_template "$taxonomy_file" "<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<?php require_once get_theme_file_path('archive-${type}.php'); ?>"
    else
      echo "[SKIP] $type はカテゴリページ不要です。"
    fi
  else
    echo "[SKIP] $type はアーカイブページ不要です。"
  fi
    # single-{type}.php
  generate_template "$single_file" "<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class=\"ly_main\">
    ※ ${type} single
</main>
<!-- /.ly_main -->
<?php get_footer(); ?>"
done

chown -R 1000:1000 "${template_dir}"