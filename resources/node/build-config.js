/************************************************************
 * ビルド設定定数
 * プロジェクト固有の設定をここに定義
 ************************************************************/

/**
 * ビルド設定
 */
export const BUILD_CONFIG = {
  // パス設定(npm実行階層からの相対)
  DIR_SRC_PATH: 'htdocs/src/',
  DIR_DIST_PATH: 'htdocs/dist/',
  DIR_IMAGE_TARGET_PATH: 'htdocs/assets/images/',

  // SCSS/CSS関連設定
  DIR_SCSS_NAME: 'scss',
  DIR_CSS_NAME: 'css',
  PRESERVE_DIRECTORY_STRUCTURE: false,

  // Browser Sync設定
  BROWSER_SYNC_PROXY: null, // プロキシモード: 例: 'php:80'、サーバーモード: null
  BROWSER_SYNC_WATCH_DIR: 'htdocs',
};

