#!/bin/bash
#===============================================
# プラグインをインストールする
# 一度全プライグインを無効化・削除（既存プラグインの設定は維持されます）
# PLUGINS配列で指定したプラグインのインストールを実行
#===============================================

ESC=$(printf '\033')

# --------------------------------
# 全プラグインを無効化・削除
# --------------------------------
# 無効化
echo "${ESC}[1;32m既存プラグインをアンインストールします・・・(設定は削除されません)${ESC}[m"
wp plugin deactivate --all --allow-root

# 削除
wp plugin delete $(wp plugin list --field=name --allow-root) --allow-root

# --------------------------------
# プラグインインストール
# --------------------------------
# プラグイン名：バージョン
echo "${ESC}[1;32mプラグインのインストールを行います・・・・・${ESC}[m"
PLUGINS=(
  "contact-form-7"
  "all-in-one-wp-migration"
  "advanced-custom-fields"
)

for entry in "${PLUGINS[@]}"; do
  IFS=":" read -r plugin_name plugin_version <<< "$entry"

  echo "インストール中: $plugin_name $( [ -n "$plugin_version" ] && echo "(バージョン: $plugin_version)" || echo "(最新バージョン)" )"

  # Contact Form 7だけ特別処理
  if [ "$plugin_name" = "contact-form-7" ] && [ "$plugin_version" = "5.7.7" ]; then
    echo "contact-form-7 5.7.7 をzipからインストール"
    wp plugin install https://downloads.wordpress.org/plugin/contact-form-7.5.7.7.zip --activate --allow-root
  else
    if [ -n "$plugin_version" ]; then
      wp plugin install "$plugin_name" --version="$plugin_version" --activate --allow-root
    else
      wp plugin install "$plugin_name" --activate --allow-root
    fi
  fi

  wp language plugin install "$plugin_name" ja --allow-root
done

# # インストール処理
# for entry in "${PLUGINS[@]}"; do
#   IFS=":" read -r plugin_name plugin_version <<< "$entry"

#   echo "インストール中: $plugin_name $( [ -n "$plugin_version" ] && echo "(バージョン: $plugin_version)" || echo "(最新バージョン)" )"

#   if [ -n "$plugin_version" ]; then
#     # バージョン指定あり
#     wp plugin install "$plugin_name" --version="$plugin_version" --activate --allow-root
#   else
#     # バージョン指定なし → 最新
#     wp plugin install "$plugin_name" --activate --allow-root
#   fi

#   # 日本語翻訳ファイルもインストール
#   wp language plugin install "$plugin_name" ja --allow-root
# done
