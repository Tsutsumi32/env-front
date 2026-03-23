#!/bin/bash
#===============================================
# 既存の投稿をすべて完全に削除する
# ----------------------------------------------
# post / page / カスタム投稿タイプの記事を対象とする
# メディア(attachment)・ナビ・テンプレート等のシステム用 post_type は除外
# ※ wp-install.sh と同様、WordPress ルート（wp-config.php があるディレクトリ）で実行すること
#===============================================

ESC=$(printf '\033')

echo "${ESC}[1;32m投稿をすべて削除します（カスタム投稿タイプを含む）…${ESC}[m"

# 削除対象外（インフラ・テーマ・プラグイン設定に紐づく post_type）
EXCLUDE_TYPES=(
  attachment
  nav_menu_item
  custom_css
  customize_changeset
  oembed_cache
  user_request
  wp_template
  wp_template_part
  wp_global_styles
  wp_navigation
  wp_font_face
  wp_font_family
  wp_block
  acf-field-group
  acf-field
)

is_excluded() {
  local t="$1"
  local x
  for x in "${EXCLUDE_TYPES[@]}"; do
    [ "$t" = "$x" ] && return 0
  done
  return 1
}

# 階層付き投稿や残リビジョン対策のため、空になるまで繰り返し削除する
delete_all_in_post_type() {
  local pt="$1"
  while true; do
    ids=$(wp post list \
      --post_type="$pt" \
      --post_status=any \
      --format=ids \
      --posts_per_page=-1 \
      --allow-root 2>/dev/null | tr -s '[:space:]' ' ' | sed 's/^ *//;s/ *$//')
    [ -z "$ids" ] && break
    # shellcheck disable=SC2086
    wp post delete $ids --force --allow-root
  done
}

while IFS= read -r post_type; do
  [ -z "$post_type" ] && continue
  if is_excluded "$post_type"; then
    continue
  fi
  echo "  → post_type: ${post_type}"
  delete_all_in_post_type "$post_type"
done < <(wp post-type list --field=name --allow-root)

echo "${ESC}[1;32m投稿の削除が完了しました。${ESC}[m"
