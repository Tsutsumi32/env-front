<?php

/**
 * サイト全体で使用する定数を定義するファイル
 */

/***********************************
 * config
 /********************************* */
// サイト情報
const SITE_NAME = 'Sample Site';
const SITE_URL  = 'http://localhost';

// テーマカラー
const THEME_COLOR = '#E2EBE6';

// webfonts
const FONT_TAGS = '<link rel="preconnect" href="https://fonts.googleapis.com">' .
    "\n" .
    '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' .
    "\n" .
    '<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">';

/***********************************
 * render-img
 /********************************* */
// ブレイクポイント
const BREAKPOINT_SP = 767;
// PC開始ブレイクポイント（BREAKPOINT_SP + 1）
const BREAKPOINT_PC = BREAKPOINT_SP + 1;
// 画像ファイル末尾サフィックス
// pcファーストの場合、render-imgでspを指定した場合に、末尾に「_sp」が付くファイル名を読み込む
const IMAGE_SUFFIX_SP = '_sp';
// spファーストの場合、render-imgでpcを指定した場合に、末尾に「_pc」が付くファイル名を読み込む
const IMAGE_SUFFIX_PC = '_pc';
// 画像パス
const IMAGE_BASE_URI        = '/assets/images';
const IMAGE_DIR_ORIGIN      = '_origin';
const IMAGE_DIR_WEBP        = 'webp';
const IMAGE_DIR_AVIF        = 'avif';
const IMAGE_DIR_COMPRESSION = 'compression';
// AVIF対応するか true:する
const RENDER_IMG_ENABLE_AVIF = true;

/***********************************
 * template
 /********************************* */
// 会社情報
const COMPANY_NAME    = 'サンプル株式会社';
const COMPANY_ADDRESS = '〒000-0000 群馬県高崎市サンプル1-2-3';
const COMPANY_TEL     = '03-1234-5678';
const COMPANY_EMAIL   = 'info@example.com';
