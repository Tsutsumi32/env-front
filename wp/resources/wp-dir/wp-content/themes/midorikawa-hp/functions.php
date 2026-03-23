<?php
if (!defined('ABSPATH')) exit;

// 定数
require_once __DIR__ . '/inc/consts/consts.php';

// 選択リスト
require_once __DIR__ . '/inc/config/list-items.php';

// 固定ページ情報
require_once __DIR__ . '/inc/classes/Page.php';

// カスタム投稿情報
require_once __DIR__ . '/inc/classes/Post.php';

// 各メソッド
require_once __DIR__ . '/inc/utils/echo-img.php';
require_once __DIR__ . '/inc/utils/get-current-page-key.php';
require_once __DIR__ . '/inc/utils/get-current-slug.php';
require_once __DIR__ . '/inc/utils/get-url.php';
require_once __DIR__ . '/inc/utils/get-img.php';
require_once __DIR__ . '/inc/utils/echo-video.php';
require_once __DIR__ . '/inc/utils/the-pagination.php';
require_once __DIR__ . '/inc/utils/auto-link-text.php';

// 共通ページネーション()
require_once __DIR__ . '/inc/utils/the-pagination.php';

// CSS・JS読み込み
require_once __DIR__ . '/inc/setup/enqueue-style-script.php';

// コメント機能オフ
require_once __DIR__ . '/inc/setup/comment-off.php';

// 通常投稿機能の削除(管理画面上)
require_once __DIR__ . '/inc/setup/remove-post-menu.php';

// メインクエリの条件指定
require_once __DIR__ . '/inc/hooks/main-query-set.php';

// 管理画面の投稿一覧に更新日を表示
require_once __DIR__ . '/inc/setup/add-mod-day.php';

// ウィジェット有効化
require_once __DIR__ . '/inc/setup/widgets-init.php';

// 管理画面デザイン変更
require_once __DIR__ . '/inc/setup/custom-admin-style.php';

// emoji対応js削除
require_once __DIR__ . '/inc/hooks/remobe-emoij.php';

// author特定防止
require_once __DIR__ . '/inc/hooks/author-redirect.php';

// rest api ユーザー特定防止
require_once __DIR__ . '/inc/hooks/filter-rest-api-uer.php';

// meta genarator 削除
require_once __DIR__ . '/inc/hooks/remove-meta-genarator.php';

// verの表示削除
require_once __DIR__ . '/inc/hooks/remove-ver.php';

// ログインリダイレクト禁止
require_once __DIR__ . '/inc/hooks/disable-login-redirect.php';

// ログイン通知メール送信
require_once __DIR__ . '/inc/hooks/send-login-mail.php';

//　カスタム投稿タイプ セットアップ
require_once __DIR__ . '/inc/setup/custom-post-setup.php';

//　タームの順番を制御するフォームを追加する
require_once __DIR__ . '/inc/setup/add-term-order-edit-form.php';

// ACF設定のロード
require_once __DIR__ . '/inc/plugins/acf/acf-inc.php';

// 通常編集機能削除
require_once __DIR__. '/inc/setup/remove-block-editor.php';

// CF7設定のロード
require_once __DIR__ . '/inc/plugins/cf7/cf7-inc.php';

// Contact Form 7の自動pタグ無効
require_once __DIR__ . '/inc/plugins/cf7/cf7-remove-tag.php';

// contactform7 バリデーション　カスタム
require_once __DIR__ . '/inc/plugins/cf7/cft-validate.php';

// プログラム上からの投稿を行う
// NOTICE 登録済みなのでコメントアウト
//require_once __DIR__ . '/inc/post/register-post-all.php';