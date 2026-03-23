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

// 設定を定数から取得（build-config でパス連結済み）
const SCSS_CONFIG = BUILD_CONFIG.SCSS;
const scssDir = SCSS_CONFIG.DIR_SRC;
const cssDir = SCSS_CONFIG.DIR_DIST;
const PRESERVE_DIRECTORY_STRUCTURE = BUILD_CONFIG.PRESERVE_DIRECTORY_STRUCTURE;
const SCSS_INDEX = BUILD_CONFIG.SCSS_INDEX;
const SCSS_INDEX_ENTRIES = Array.isArray(SCSS_INDEX) ? SCSS_INDEX : [SCSS_INDEX];

let postcssTimeout;
let isPostcssRunning = false;
let compileTimeout;
let isCompileRunning = false;

/**
 * 指定されたファイルパスがいずれかのエントリのTARGET_DIRS内に含まれているかチェック
 */
function isInTargetDirs(filePath) {
  return getEntriesContainingFile(filePath).length > 0;
}

/**
 * 指定されたファイルパスが属するエントリ（そのファイルをTARGET_DIRSに含むエントリ）を返す
 */
function getEntriesContainingFile(filePath) {
  const normalizedFilePath = normalize(resolve(filePath)).replace(/\\/g, '/');
  const cwd = process.cwd().replace(/\\/g, '/');

  return SCSS_INDEX_ENTRIES.filter((entry) => {
    const targetDirs = entry.TARGET_DIRS || [];
    return targetDirs.some((targetDir) => {
      const absoluteTargetDir = normalize(resolve(cwd, targetDir)).replace(/\\/g, '/');
      return normalizedFilePath.startsWith(absoluteTargetDir + '/') ||
             normalizedFilePath === absoluteTargetDir;
    });
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
      const entries = getEntriesContainingFile(scssPath);
      if (entries.length > 0) {
        // いずれかのエントリが 'all' なら全ファイル、そうでなければ属するエントリのみコンパイル
        const useAll = entries.some((e) => (e.PARTIAL_CHANGE_COMPILE || 'entry') === 'all');
        if (useAll) {
          console.log(`🔄 パーシャル変更: 全ファイルコンパイル`);
          await recompileAllScssFiles();
        } else {
          console.log(`🔄 パーシャル変更: 属するエントリをコンパイル`);
          await compileEntryFiles(entries);
        }
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

/**
 * 指定されたエントリのOUTPUT_FILEをコンパイルする
 * パーシャル変更時に、変更ファイルが属するエントリだけをコンパイルするために使用
 */
async function compileEntryFiles(entries) {
  const validEntries = entries.filter((e) => e.OUTPUT_FILE);

  if (validEntries.length === 0) {
    console.warn('⚠️  コンパイル対象のOUTPUT_FILEが設定されていません');
    return;
  }

  for (const entry of validEntries) {
    const outputFile = entry.OUTPUT_FILE;
    let outputPath;
    const relativePath = relative(scssDir, outputFile);

    if (PRESERVE_DIRECTORY_STRUCTURE) {
      outputPath = join(cssDir, relativePath.replace('.scss', '.css'));
    } else {
      const fileName = relativePath.split(/[/\\]/).pop().replace('.scss', '.css');
      outputPath = join(cssDir, fileName);
    }

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
  }

  // PostCSSを実行
  if (postcssTimeout) clearTimeout(postcssTimeout);
  postcssTimeout = setTimeout(async () => {
    if (isPostcssRunning) return;
    isPostcssRunning = true;
    await runPostcss();
    isPostcssRunning = false;
  }, 500);
}

/**
 * IMPORT_TYPE が 'use' のエントリをすべてコンパイルする（ビルド時などで使用）
 */
async function compileCommonScss() {
  const compileEntries = SCSS_INDEX_ENTRIES.filter((e) => (e.IMPORT_TYPE || 'use') === 'use');
  await compileEntryFiles(compileEntries);
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
