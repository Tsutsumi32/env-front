import chokidar from 'chokidar';
import {
  // runStylelint,
  runPostcss,
  cleanOrphanCssFiles,
  runCommand,
  collectScssFiles
} from './logic-scss.js';
import { BUILD_CONFIG } from '../build-config.js';
import { join, dirname, relative } from 'path';
import { mkdirSync } from 'fs';

// 設定を定数から取得
const DIR_SRC_PATH = BUILD_CONFIG.DIR_SRC_PATH;
const DIR_DIST_PATH = BUILD_CONFIG.DIR_DIST_PATH;
const DIR_SCSS_NAME = BUILD_CONFIG.DIR_SCSS_NAME;
const DIR_CSS_NAME = BUILD_CONFIG.DIR_CSS_NAME;
const PRESERVE_DIRECTORY_STRUCTURE = BUILD_CONFIG.PRESERVE_DIRECTORY_STRUCTURE;

let postcssTimeout;
let isPostcssRunning = false;
let compileTimeout;
let isCompileRunning = false;

const scssDir = `${DIR_SRC_PATH}${DIR_SCSS_NAME}`;
const cssDir = `${DIR_DIST_PATH}${DIR_CSS_NAME}`;

// SCSSファイルをコンパイルする関数
async function compileScssFile(scssPath) {
  // scssDirからの相対パスを取得
  const relativePath = relative(scssDir, scssPath);

  // index.scssと_で始まるファイルはスキップ
  const fileName = relativePath.split(/[/\\]/).pop();
  if (fileName === 'index.scss' || fileName.startsWith('_')) {
    console.log(`⏭️  スキップ: ${relativePath.replace(/\\/g, '/')} (index.scss またはパーシャル)`);
    // パーシャルファイルが変更された場合は、すべてのSCSSファイルを再コンパイル
    if (fileName.startsWith('_')) {
      console.log(`🔄 パーシャル変更検知: すべてのSCSSファイルを再コンパイルします`);
      await recompileAllScssFiles();
    }
    return;
  }

  let outputPath;

  if (PRESERVE_DIRECTORY_STRUCTURE) {
    // ディレクトリ構造を維持
    outputPath = join(cssDir, relativePath.replace('.scss', '.css'));
  } else {
    // 1階層に全て出力（ファイル名のみを使用）
    const cssFileName = fileName.replace('.scss', '.css');
    outputPath = join(cssDir, cssFileName);
  }

  // 出力先ディレクトリが存在しない場合は作成
  const outputDir = dirname(outputPath);
  try {
    mkdirSync(outputDir, { recursive: true });
  } catch (error) {
    // ディレクトリが既に存在する場合は無視
  }

  const displayPath = relativePath.replace(/\\/g, '/');
  console.log(`📝 コンパイル: ${displayPath}`);
  await runCommand(
    `npx sass --source-map ${scssPath}:${outputPath}`,
    displayPath
  );

  // PostCSSを実行
  if (postcssTimeout) clearTimeout(postcssTimeout);
  postcssTimeout = setTimeout(async () => {
    if (isPostcssRunning) return;
    isPostcssRunning = true;
    await runPostcss();
    isPostcssRunning = false;
  }, 500);
}

// すべてのSCSSファイルを再コンパイルする関数
async function recompileAllScssFiles() {
  const scssFiles = collectScssFiles(scssDir);

  const compileTasks = scssFiles.map(({ srcPath, relativePath }) => {
    let outputPath;

    if (PRESERVE_DIRECTORY_STRUCTURE) {
      // ディレクトリ構造を維持
      outputPath = join(cssDir, relativePath.replace('.scss', '.css'));
    } else {
      // 1階層に全て出力（ファイル名のみを使用）
      const fileName = relativePath.split(/[/\\]/).pop().replace('.scss', '.css');
      outputPath = join(cssDir, fileName);
    }

    // 出力先ディレクトリが存在しない場合は作成
    const outputDir = dirname(outputPath);
    try {
      mkdirSync(outputDir, { recursive: true });
    } catch (error) {
      // ディレクトリが既に存在する場合は無視
    }

    const relativeDisplay = relativePath.replace(/\\/g, '/');
    return runCommand(
      `npx sass --source-map ${srcPath}:${outputPath}`,
      relativeDisplay
    );
  });

  await Promise.all(compileTasks);

  // PostCSSを実行
  if (postcssTimeout) clearTimeout(postcssTimeout);
  postcssTimeout = setTimeout(async () => {
    if (isPostcssRunning) return;
    isPostcssRunning = true;
    await runPostcss();
    isPostcssRunning = false;
  }, 500);
}

// 監視パス（ディレクトリ単位で監視）
const watchPaths = [
  scssDir // ディレクトリ単位でOK（再帰的に全 .scss を監視）
];

// ファイル変更ハンドラー
function handleChange(scssPath) {
  if (!scssPath.endsWith('.scss')) return;

  if (compileTimeout) clearTimeout(compileTimeout);
  compileTimeout = setTimeout(async () => {
    if (isCompileRunning) return;
    isCompileRunning = true;
    await compileScssFile(scssPath);
    isCompileRunning = false;
  }, 200);
}

// SCSSファイルの監視を開始
chokidar
  .watch(watchPaths, {
    ignored: /(^|[/\\])\../, // 隠しファイル除外
    persistent: true,
    ignoreInitial: true,
    usePolling: false,
    depth: 99,
    awaitWriteFinish: {
      stabilityThreshold: 100,
      pollInterval: 50,
    },
  })
  .on('ready', () => {
    console.log('🟢 SCSSファイル監視 スタート');
  })
  .on('add', handleChange)
  .on('change', handleChange)
  .on('unlink', (scssPath) => {
    console.log(`🗑️  削除検知: ${relative(scssDir, scssPath).replace(/\\/g, '/')}`);
    cleanOrphanCssFiles();
  });
