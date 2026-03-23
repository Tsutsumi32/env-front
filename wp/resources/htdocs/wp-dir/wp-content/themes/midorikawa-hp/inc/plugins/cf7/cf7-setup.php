<?php
/***************************************************
    CF7セットアップ
 ****************************************************/
require_once __DIR__ . '/cf7.php';

function cf7_setup()
{
    foreach (CONTACT_FORMS as $form) {
        // 既存のフォームをWP_Queryで検索
        $args = array(
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'any',
            'posts_per_page' => 1,
            'title'          => $form['title'],
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            // 既存のフォームを更新
            $existing_form = $query->posts[0];
            $form_id = $existing_form->ID;

            // フォーム内容だけを更新し、メール設定は更新しない
            update_post_meta($form_id, '_form', $form['form']);
        } else {
            // 新規フォーム作成（メール設定なし）
            $properties = array(
                'title' => $form['title'],
                'form' => $form['form'],
                'locale' => determine_locale()
            );

            // フォームを作成
            $contact_form = wpcf7_save_contact_form($properties);
        }

        // クエリのリセット
        wp_reset_postdata();
    }
}
add_action('wpcf7_init', 'cf7_setup');
?>