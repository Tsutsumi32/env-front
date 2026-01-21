import chokidar from 'chokidar';
import {
  // runStylelint,
  runPostcss,
  cleanOrphanCssFiles,
  runCommand,
  collectScssFiles
} from './logic-scss.js';
import { BUILD_CONFIG } from '../../build-config.js';
import { join, dirname, relative, resolve, normalize } from 'path';
import { mkdirSync } from 'fs';

// 設定を定数から取得
const DIR_SRC_PATH = BUILD_CONFIG.DIR_SRC_PATH;
const DIR_DIST_PATH = BUILD_CONFIG.DIR_DIST_PATH;
const DIR_SCSS_NAME = BUILD_CONFIG.DIR_SCSS_NAME;
const DIR_CSS_NAME = BUILD_CONFIG.DIR_CSS_NAME;
const PRESERVE_DIRECTORY_STRUCTURE = BUILD_CONFIG.PRESERVE_DIRECTORY_STRUCTURE;
const SCSS_INDEX = BUILD_CONFIG.SCSS_INDEX;

let postcssTimeout;
let isPostcssRunning = false;
let compileTimeout;
let isCompileRunning = false;

const scssDir = `${DIR_SRC_PATH}${DIR_SCSS_NAME}`;
const cssDir = `${DIR_DIST_PATH}${DIR_CSS_NAME}`;

/**
 * 指定されたファイルパスがTARGET_DIRS内のディレクトリに含まれているかチェック
 */
function isInTargetDirs(filePath) {
  const targetDirs = SCSS_INDEX.TARGET_DIRS || [];

  if (targetDirs.length === 0) {
    return false;
  }

  // ファイルパスを絶対パスに正規化
  const normalizedFilePath = normalize(resolve(filePath)).replace(/\\/g, '/');

  // 現在の作業ディレクトリ（npm実行階層）を取得
  const cwd = process.cwd().replace(/\\/g, '/');

  return targetDirs.some((targetDir) => {
    // 対象ディレクトリを絶対パスに変換
    const absoluteTargetDir = normalize(resolve(cwd, targetDir)).replace(/\\/g, '/');
    // ファイルパスが対象ディレクトリの配下にあるかチェック
    return normalizedFilePath.startsWith(absoluteTargetDir + '/') ||
           normalizedFilePath === absoluteTargetDir;
  });
}

// SCSSファイルをコンパイルする関数
async function compileScssFile(scssPath) {
  // scssDirからの相対パスを取得
  const relativePath = relative(scssDir, scssPath);

  // index.scssと_で始まるファイルはスキップ
  const fileName = relativePath.split(/[/\\]/).pop();
  if (fileName === 'index.scss' || fileName.startsWith('_')) {
    // パーシャルファイルが変更された場合の処理
    if (fileName.startsWith('_')) {
      // TARGET_DIRS内のパーシャルファイルの場合、common.scssのみ再コンパイル
      if (isInTargetDirs(scssPath)) {
        console.log(`🔄 パーシャル変更: common.scssコンパイル`);
        await compileCommonScss();
      } else {
        // TARGET_DIRSにないパーシャルファイルの場合、すべてのSCSSファイルを再コンパイル
        console.log(`🔄 パーシャル変更: 全ファイルコンパイル`);
        await recompileAllScssFiles();
      }
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

// common.scssをコンパイルする関数
async function compileCommonScss() {
  const outputFile = SCSS_INDEX.OUTPUT_FILE;

  if (!outputFile) {
    console.warn('⚠️  OUTPUT_FILEが設定されていません');
    return;
  }

  let outputPath;
  const relativePath = relative(scssDir, outputFile);

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

  const displayPath = relativePath.replace(/\\/g, '/');
  console.log(`📝 コンパイル: ${displayPath}`);
  await runCommand(
    `npx sass --source-map ${outputFile}:${outputPath}`,
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
