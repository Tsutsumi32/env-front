// logic-scss-index.js
import { BUILD_CONFIG } from '../../build-config.js';
import { join, dirname, relative } from 'path';
import { writeFileSync, mkdirSync, readdirSync, lstatSync, existsSync } from 'fs';

/**
 * 指定したディレクトリ内のSCSSファイルを収集（index.scssと_で始まるファイルを除外）
 */
export function collectScssFiles(targetDir) {
  const files = [];

  if (!existsSync(targetDir)) {
    return files;
  }

  try {
    const entries = readdirSync(targetDir);

    for (const entry of entries) {
      const fullPath = join(targetDir, entry);
      const stat = lstatSync(fullPath);

      if (stat.isDirectory()) {
        // ディレクトリの場合は再帰的に探索
        files.push(...collectScssFiles(fullPath));
      } else if (entry.endsWith('.scss')) {
        // index.scssのみを除外（パーシャルファイルは含める）
        if (entry === 'index.scss') {
          continue;
        }
        // 対象ディレクトリからの相対パスを取得
        const relativePath = relative(targetDir, fullPath);
        files.push({
          relativePath: relativePath.replace(/\\/g, '/'),
          baseName: entry.replace('.scss', '')
        });
      }
    }
  } catch (error) {
    // エラーが発生した場合は無視
    console.warn(`警告: ${targetDir} の読み取りでエラーが発生しました: ${error.message}`);
  }

  return files;
}

/**
 * SCSSインデックスファイルのコンテンツを生成
 */
export function generateScssIndexContent() {
  const SCSS_INDEX = BUILD_CONFIG.SCSS_INDEX;
  const outputFile = SCSS_INDEX.OUTPUT_FILE;
  const targetDirs = SCSS_INDEX.TARGET_DIRS;

  // common.scssのディレクトリを取得（相対パス計算用）
  const outputDirPath = dirname(outputFile);

  let content = '';

  // 各対象ディレクトリを順に処理
  targetDirs.forEach((targetDir) => {
    // ディレクトリ名を取得（パスの最後の部分）
    const dirName = targetDir.split(/[/\\]/).pop();

    // ディレクトリコメントを追加
    content += `/***********************************************************\n`;
    content += `/*  ${dirName}\n`;
    content += `************************************************************/\n`;

    // 対象ディレクトリ直下にindex.scssがあるかチェック
    const indexScssPath = join(targetDir, 'index.scss');
    const hasIndexScss = existsSync(indexScssPath);

    if (hasIndexScss) {
      // index.scssがある場合は、それだけを@useする（拡張子なしのディレクトリパス）
      const relativePath = relative(outputDirPath, targetDir);
      const usePath = `./${relativePath.replace(/\\/g, '/')}`;
      content += `@use '${usePath}';\n`;
      content += '\n';
    } else {
      // index.scssがない場合は、ディレクトリ内のSCSSファイルを収集
      const scssFiles = collectScssFiles(targetDir);

      // ファイルをソート（アルファベット順）
      scssFiles.sort((a, b) => a.relativePath.localeCompare(b.relativePath));

      // @use文を追加
      scssFiles.forEach((file) => {
        // 相対パスを作成（common.scssからの相対パス）
        // 各ファイルのフルパス = targetDir + file.relativePath
        const fileFullPath = join(targetDir, file.relativePath);
        const relativePath = relative(outputDirPath, fileFullPath);
        const usePath = `./${relativePath.replace(/\\/g, '/')}`;
        content += `@use '${usePath}';\n`;
      });

      // ディレクトリ間に空行を追加
      if (scssFiles.length > 0) {
        content += '\n';
      }
    }
  });

  return content;
}

/**
 * SCSSインデックスファイルを生成
 */
export function generateScssIndexFile() {
  const SCSS_INDEX = BUILD_CONFIG.SCSS_INDEX;
  const outputFile = SCSS_INDEX.OUTPUT_FILE;

  // 出力ファイルのディレクトリが存在しない場合は作成
  const outputDir = dirname(outputFile);
  if (!existsSync(outputDir)) {
    mkdirSync(outputDir, { recursive: true });
  }

  // コンテンツを生成
  const content = generateScssIndexContent();

  // ファイルに書き込み
  writeFileSync(outputFile, content, 'utf8');
}
