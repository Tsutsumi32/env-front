/************************************************************
 * フロントエンドビルド設定定数
 * resources/配下のスクリプトで使用する設定を定義する
 * DIR_SRC_PATH / DIR_DIST_PATH を基準にパスを連結して定義する
 ************************************************************/

const DIR_SRC_PATH = 'htdocs/src/';
const DIR_DIST_PATH = 'htdocs/dist/';

/**
 * ビルド設定
 */
export const BUILD_CONFIG = {
  // パス設定(npm実行階層からの相対)
  DIR_SRC_PATH,
  DIR_DIST_PATH,
  // 画像の格納親ディレクトリ
  DIR_IMAGE_TARGET_PATH: 'htdocs/assets/images/',

  // SCSS/CSS関連（パスを連結して指定）
  SCSS: {
    DIR_SRC: DIR_SRC_PATH + 'scss/',
    DIR_DIST: DIR_DIST_PATH + 'css/',
  },
  // 出力の際にディレクトリ階層を維持するか
  PRESERVE_DIRECTORY_STRUCTURE: false,

  // JS関連（パスを連結して指定）
  JS: {
    DIR_SRC: DIR_SRC_PATH + 'js/',
    DIR_DIST: DIR_DIST_PATH + 'js/',

    // ビルドモード
    // - 'entry': ページごとエントリ（entry/*.js → dist/*.js）。entry 変更時はその1件のみ、依存変更時は全エントリをビルド。
    // - 'dynamic': 単一エントリ（main.js）で動的 import。pages 等はチャンクで出力。依存変更時はその1ビルドを実行。
    BUILD_MODE: 'entry',

    // ---- entry モード用 ----
    // エントリ配置ディレクトリ（直下の *.js を dist/*.js で出力。pages と同名の .js を置く）
    ENTRY_DIRS: [DIR_SRC_PATH + 'js/entry'],
    // 同名の entry のみビルドする依存ディレクトリ（例: pages/top.js 変更 → entry/top.js のみビルド。pages と entry は同名前提）
    ENTRY_DEPENDS_NAMED_DIRS: [DIR_SRC_PATH + 'js/pages'],
    // 上以外の依存ディレクトリ（ここが変更されたら全エントリを再ビルド）
    ENTRY_DEPENDS_DIRS: [
      DIR_SRC_PATH + 'js/lifecycle',
      DIR_SRC_PATH + 'js/common',
      DIR_SRC_PATH + 'js/core',
      DIR_SRC_PATH + 'js/modules',
      DIR_SRC_PATH + 'js/utils',
    ],

    // ---- dynamic モード用（BUILD_MODE === 'dynamic' のとき使用）----
    // 動的 import の単一エントリ（main.js 等）
    DYNAMIC_ENTRY: DIR_SRC_PATH + 'js/main.js',
    // 動的 import で読み込まれるディレクトリ（ここが変更されたら dynamic ビルドを実行＝チャンクが更新される）
    DYNAMIC_DEPENDS_DIRS: [
      DIR_SRC_PATH + 'js/pages',
      DIR_SRC_PATH + 'js/lifecycle',
      DIR_SRC_PATH + 'js/common',
      DIR_SRC_PATH + 'js/core',
      DIR_SRC_PATH + 'js/modules',
    ],
  },

  // SCSSインデックス生成設定（複数指定可能）
  // 各エントリは「生成するファイル」と「そのファイルに読み込むターゲットパス」をセットで管理
  SCSS_INDEX: [
    {
      // 生成するエントリーファイルのパス（npm実行階層からの相対パス）
      OUTPUT_FILE: 'htdocs/src/scss/common.scss',
      // 対象ディレクトリの配列（上から順に読み込まれる）
      // 各ディレクトリは npm実行階層からの相対パス
      OUTPUT_FILE: DIR_SRC_PATH + 'scss/common.scss',
      TARGET_DIRS: [
        DIR_SRC_PATH + 'scss/global',
        DIR_SRC_PATH + 'scss/helpers',
        DIR_SRC_PATH + 'scss/utils',
        DIR_SRC_PATH + 'scss/js-contracts',
        DIR_SRC_PATH + 'scss/modules/elements',
        // ほぼ全画面に使用するblock。それ以外は画面で手動import
        DIR_SRC_PATH + 'scss/modules/blocks-shared',
        DIR_SRC_PATH + 'scss/modules/footer',
        DIR_SRC_PATH + 'scss/modules/header',
        DIR_SRC_PATH + 'scss/modules/layouts',
      ],
      // 読み込み方法: 'use' または 'forward'（省略時は 'use'）
      IMPORT_TYPE: 'use',
      // PARTIAL_CHANGE_COMPILE: パーシャル変更時 'entry'=属するエントリのみ / 'all'=全ファイル
      PARTIAL_CHANGE_COMPILE: 'entry',
    },
    {
      OUTPUT_FILE: DIR_SRC_PATH + 'scss/foundation/index.scss',
      TARGET_DIRS: [
        DIR_SRC_PATH + 'scss/foundation/functions',
        DIR_SRC_PATH + 'scss/foundation/mixins',
        DIR_SRC_PATH + 'scss/foundation/variables',
        DIR_SRC_PATH + 'scss/foundation/project',
        DIR_SRC_PATH + 'scss/foundation/animation',
      ],
      IMPORT_TYPE: 'forward',
      PARTIAL_CHANGE_COMPILE: 'all',
    },
  ],

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
    COMPRESSION_MODE: 'width', // 'width' または 'scale'
    // compression画像の横幅（ピクセル単位、COMPRESSION_MODEが'width'の場合に使用、アスペクト比は維持される）
    COMPRESSION_WIDTH: 2200,
    // compression画像の圧縮率（0.0〜1.0、COMPRESSION_MODEが'scale'の場合に使用、アスペクト比は維持される）
    // 例: 0.5 = 50%のサイズ、0.8 = 80%のサイズ
    COMPRESSION_SCALE: 0.5,
    // compression画像のJPEG画質設定（元画像がjpg/jpegの場合に使用）
    // quality: 1〜100（数値が高いほど高品質、ファイルサイズも大きくなる）
    // 例: 85 = 高品質、70 = 標準、50 = 低品質
    COMPRESSION_JPEG_QUALITY: 90,
  },
};
