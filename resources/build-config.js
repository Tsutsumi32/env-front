/************************************************************
 * フロントエンドビルド設定定数
 * resources/配下のスクリプトで使用する設定を定義する
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
  // 出力の際にディレクトリ階層を維持するか
  PRESERVE_DIRECTORY_STRUCTURE: false,

  // Browser Sync設定
  // プロキシモード: 例: 'php:80'、サーバーモード: null
  BROWSER_SYNC_PROXY: 'php:80',
  BROWSER_SYNC_WATCH_DIR: 'htdocs',

  // 画像変換設定
  IMAGE_CONVERT: {
    // 各形式の出力有効/無効
    ENABLE_AVIF: false,
    ENABLE_WEBP: false,
    ENABLE_COMPRESSION: true,
    // AVIF変換のクオリティ設定
    // quality: 1〜100（数値が高いほど高品質、ファイルサイズも大きくなる）
    // effort: 0〜9（数値が高いほど圧縮効率が良いが処理時間が長くなる）
    AVIF_QUALITY: 80,
    AVIF_EFFORT: 4,
    // WebP変換のクオリティ設定
    // quality: 1〜100（数値が高いほど高品質、ファイルサイズも大きくなる）
    WEBP_QUALITY: 80,
    // compression画像の変換方法
    // 'width': 横幅を指定（COMPRESSION_WIDTHを使用）
    // 'scale': 圧縮率を指定（COMPRESSION_SCALEを使用）
    // 例: COMPRESSION_MODE: 'width', COMPRESSION_WIDTH: 1200
    // 例: COMPRESSION_MODE: 'scale', COMPRESSION_SCALE: 0.5
    COMPRESSION_MODE: 'scale', // 'width' または 'scale'
    // compression画像の横幅（ピクセル単位、COMPRESSION_MODEが'width'の場合に使用、アスペクト比は維持される）
    COMPRESSION_WIDTH: 900,
    // compression画像の圧縮率（0.0〜1.0、COMPRESSION_MODEが'scale'の場合に使用、アスペクト比は維持される）
    // 例: 0.5 = 50%のサイズ、0.8 = 80%のサイズ
    COMPRESSION_SCALE: 0.5,
    // compression画像のJPEG画質設定（元画像がjpg/jpegの場合に使用）
    // quality: 1〜100（数値が高いほど高品質、ファイルサイズも大きくなる）
    // 例: 85 = 高品質、70 = 標準、50 = 低品質
    COMPRESSION_JPEG_QUALITY: 90,
  },
};

