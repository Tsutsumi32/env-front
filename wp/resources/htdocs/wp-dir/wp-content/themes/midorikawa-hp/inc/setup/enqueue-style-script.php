<?php
/***************************************************
    CSS・JS読み込み
 ****************************************************/
/**
 * 全画面共通で読み込むスタイル・スクリプト
 */
function enqueue_common_file()
{
    // 共通CSSファイル
    wp_enqueue_style(
        'style-common',
        get_template_directory_uri() . '/assets/css/common.css',
        array(),
        date('YmdHi'),
        'all'
    );

    // jQuery（CDN）
    wp_enqueue_script(
        'jquery-cdn',
        'https://code.jquery.com/jquery-3.6.0.min.js',
        array(),
        '3.6.0',
        true
    );

    // 共通JavaScriptファイル
    wp_enqueue_script(
        'script-common',
        get_template_directory_uri() . '/assets/js/common.js',
        array(),
        date('YmdHi'),
        true
    );

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com',
        array(),
        null
    );
    wp_enqueue_style(
        'google-fonts-static',
        'https://fonts.gstatic.com',
        array(),
        null
    );
    wp_enqueue_style(
        'google-fonts-all',
        'https://fonts.googleapis.com/css2?family=BIZ+UDPGothic:wght@400;700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        null
    );
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'enqueue_common_file');

/**
 * 各画面名に対応したスタイル・スクリプト
 */
function enqueue_pages_file()
{
    $file_name = get_current_slug();

    // ダウンロードフォームの場合は変更
    if(is_page(Page::CONTACT_DOWNLOAD)) {
        $file_name = Page::CONTACT;
    }

    // 詳細ページの場合
    if (is_singular(get_current_slug())) {
        $file_name = 'single-' . get_current_slug();
    }

    // 加工/施工詳細は、製品詳細と同じスタイルの読み込み
    if (is_singular(Post::PROCESSED_PRODUCTION)) {
        $file_name = 'single-' . Post::PRODUCT;
    }

    // 個別ファイル読み込み
    if ($file_name) {
        $css_file_path = get_template_directory() . '/assets/css/' . $file_name . '.css';
        $js_file_path = get_template_directory() . '/assets/js/' . $file_name . '.js';
        if (file_exists($css_file_path)) {
            wp_enqueue_style(
                'style' . $file_name,
                get_template_directory_uri() . '/assets/css/' . $file_name . '.css',
                array(),
                date('YmdHi'),
                'all'
            );
        }
        if (file_exists($js_file_path)) {
            wp_enqueue_script(
                'script' . $file_name,
                get_template_directory_uri() . '/assets/js/' . $file_name . '.js',
                array(),
                date('YmdHi'),
                true
            );
            wp_localize_script('script' . $file_name, 'themeData', array(
                // JavaScript にテーマのパスを渡す
                'themeUrl' => get_template_directory_uri(),
                // JavaScript にajaxのURLを渡す
                'ajax_url' => admin_url('admin-ajax.php'),
            ));
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_pages_file');

/**
 * Swiper
 */
function enqueue_swiper_assets()
{
    if (
        is_front_page()
        || is_home()
        || is_page(Page::RECRUIT)
        || is_singular(Post::PRODUCT)
        || is_singular(Post::PROCESSED_PRODUCTION)
    ) {
        wp_enqueue_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
            array(),
            '8',
            true
        );
        wp_enqueue_style(
            'swiper-style',
            'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css',
            array(),
            '8',
            'all'
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');

/**
 * form.js
 */
function enqueue_form_js()
{
    if (
        is_page(Page::CONTACT)
        || is_page(Page::CONTACT_DOWNLOAD)
    ) {
        wp_enqueue_script(
            '
            script-form',
            get_template_directory_uri() . '/assets/js/form.js',
            array(),
            date('YmdHi'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_form_js');


/**
 * anchorlink.js
 */
function enqueue_anchorlink_js()
{
    if (
        is_page(Page::COMPANY)
        || is_page(Page::RECRUIT)
        || is_page(Page::CONTACT)
        || is_page(Page::PRODUCTION_VEHICLE)
        || is_page(Page::PRODUCTION_FACTORY)
        || is_page(Page::PRODUCTION_MEDICAL)
        || is_page(Page::PRODUCTION_ENVIRONMENT)
        || is_page(Page::PRODUCTION_OFFICE)
        || is_page(Page::PRODUCTION_COMMERCIAL)
        || is_page(Page::PRODUCTION_AMUSEMENT)
        || is_page(Page::PRODUCTION_AGRICULTURE)
    ) {
        wp_enqueue_script(
            'script-anchorlink',
            get_template_directory_uri() . '/assets/js/anchorlink.js',
            array(),
            date('YmdHi'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_anchorlink_js');

/**
 * search.js
 */
function enqueue_search_js()
{
    if (
        is_page(Page::TRAIDING)
    ) {
        wp_enqueue_script(
            'script-search',
            get_template_directory_uri() . '/assets/js/search.js',
            array(),
            date('YmdHi'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_search_js');