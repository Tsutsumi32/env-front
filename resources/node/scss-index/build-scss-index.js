// build-scss-index.js
import { BUILD_CONFIG } from '../../build-config.js';
import { generateScssIndexFile } from './logic-scss-index.js';

/**
 * common.scssファイルを生成
 */
function generateScssIndex() {
  console.log('🟢 SCSSインデックス生成開始...');

  const SCSS_INDEX = BUILD_CONFIG.SCSS_INDEX;
  const outputFile = SCSS_INDEX.OUTPUT_FILE;

  generateScssIndexFile();
  console.log(`✅ SCSSインデックス生成完了: ${outputFile}`);
}

// 実行
generateScssIndex();
