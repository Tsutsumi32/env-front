// scss-tasks.js
import { exec } from 'child_process';
import { readdirSync, unlinkSync, lstatSync } from 'fs';
import { join } from 'path';
import { BUILD_CONFIG } from '../build-config.js';

export function runCommand(cmd, label = '') {
  return new Promise((resolve) => {
    exec(cmd, (error, stdout, stderr) => {
      if (label) console.log(`▶ ${label}`);
      if (stdout) console.log(stdout.trim());
      if (stderr) console.error(stderr.trim());
      resolve({ error });
    });
  });
}

// export async function runStylelint() {
//   console.log('📝 StyleLint チェック...');
//   const { error } = await runCommand(`npx stylelint "${DIR_SRC_PATH}scss/**/*.scss"`, 'StyleLint');
//   if (error) {
//     console.warn('❌ StyleLint エラー');
//     return false;
//   } else {
//     console.log('✅ StyleLint 完了');
//     return true;
//   }
// }

// 再帰的にSCSSファイルを収集するヘルパー関数（index.scssと_で始まるファイルを除外）
export function collectScssFiles(scssDir, basePath = '') {
  const files = [];
  const fullScssDir = basePath ? join(scssDir, basePath) : scssDir;

  try {
    const entries = readdirSync(fullScssDir);

    for (const entry of entries) {
      const fullPath = join(fullScssDir, entry);
      const stat = lstatSync(fullPath);

      if (stat.isDirectory()) {
        // ディレクトリの場合は再帰的に探索
        const newBasePath = basePath ? join(basePath, entry) : entry;
        files.push(...collectScssFiles(scssDir, newBasePath));
      } else if (entry.endsWith('.scss')) {
        // index.scssと_で始まるファイル（パーシャル）を除外
        if (entry === 'index.scss' || entry.startsWith('_')) {
          continue;
        }
        const relativePath = basePath ? join(basePath, entry) : entry;
        files.push({
          srcPath: fullPath,
          relativePath: relativePath,
          baseName: entry.replace('.scss', '')
        });
      }
    }
  } catch (error) {
    // ディレクトリが存在しない場合は無視
  }

  return files;
}

// 再帰的にCSSファイルを収集するヘルパー関数
function collectCssFiles(dir) {
  const files = [];
  const entries = readdirSync(dir);

  for (const entry of entries) {
    const fullPath = join(dir, entry);
    const stat = lstatSync(fullPath);

    if (stat.isDirectory()) {
      files.push(...collectCssFiles(fullPath));
    } else if (entry.endsWith('.css')) {
      files.push(fullPath);
    }
  }

  return files;
}

export async function runPostcss() {
  console.log('🛠️ PostCSS 開始...');

  // 設定を定数から取得
  const DIR_DIST_PATH = BUILD_CONFIG.DIR_DIST_PATH;
  const DIR_CSS_NAME = BUILD_CONFIG.DIR_CSS_NAME;
  const cssDir = `${DIR_DIST_PATH}${DIR_CSS_NAME}`;

  // ディレクトリ構造維持モードに関係なく、再帰的にすべてのCSSファイルを処理
  const cssFiles = collectCssFiles(cssDir);
  const tasks = cssFiles.map(filepath =>
    runCommand(`npx postcss ${filepath} --map --replace`)
  );

  await Promise.all(tasks);
  console.log('✅ PostCSS 完了');
}


// ✅ 孤立CSS・MAP削除
export function cleanOrphanCssFiles() {
  console.log('🗑️ 不要な CSS / MAP ファイル削除チェック...');

  // 設定を定数から取得
  const DIR_SRC_PATH = BUILD_CONFIG.DIR_SRC_PATH;
  const DIR_DIST_PATH = BUILD_CONFIG.DIR_DIST_PATH;
  const DIR_SCSS_NAME = BUILD_CONFIG.DIR_SCSS_NAME;
  const DIR_CSS_NAME = BUILD_CONFIG.DIR_CSS_NAME;
  const PRESERVE_DIRECTORY_STRUCTURE = BUILD_CONFIG.PRESERVE_DIRECTORY_STRUCTURE;

  const cssDir = `${DIR_DIST_PATH}${DIR_CSS_NAME}`;
  const scssDir = `${DIR_SRC_PATH}${DIR_SCSS_NAME}`;

  // コンパイル対象のSCSSファイル一覧を取得
  const validScssFiles = collectScssFiles(scssDir);
  const validCssPaths = new Set();

  validScssFiles.forEach(({ relativePath }) => {
    if (PRESERVE_DIRECTORY_STRUCTURE) {
      // ディレクトリ構造を維持する場合
      const cssRelativePath = relativePath.replace('.scss', '.css');
      validCssPaths.add(join(cssDir, cssRelativePath));
      validCssPaths.add(join(cssDir, cssRelativePath + '.map'));
    } else {
      // 1階層に全て出力する場合
      const fileName = relativePath.split(/[/\\]/).pop().replace('.scss', '.css');
      validCssPaths.add(join(cssDir, fileName));
      validCssPaths.add(join(cssDir, fileName + '.map'));
    }
  });

  function processDirectory(dir) {
    const entries = readdirSync(dir);

    entries.forEach((entry) => {
      const fullPath = join(dir, entry);
      const stat = lstatSync(fullPath);

      if (stat.isDirectory()) {
        // ディレクトリの場合は再帰的に処理
        processDirectory(fullPath);
      } else if (entry.endsWith('.css') || entry.endsWith('.css.map')) {
        // 有効なCSSファイルリストに含まれていない場合は削除
        if (!validCssPaths.has(fullPath)) {
          unlinkSync(fullPath);
          console.log(`🗑️ 削除済み: ${fullPath}`);
        }
      }
    });
  }

  processDirectory(cssDir);
}
