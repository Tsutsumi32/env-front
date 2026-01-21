// watch-scss-index.js
import chokidar from 'chokidar';
import { BUILD_CONFIG } from '../../build-config.js';
import { generateScssIndexFile } from './logic-scss-index.js';

const SCSS_INDEX = BUILD_CONFIG.SCSS_INDEX;

const targetDirs = SCSS_INDEX.TARGET_DIRS;

// 監視対象のディレクトリパスを作成
const watchPaths = targetDirs;

let rebuildTimeout;
let isRebuilding = false;

/**
 * common.scssを再生成
 */
function rebuildScssIndex() {
  if (isRebuilding) return;

  if (rebuildTimeout) {
    clearTimeout(rebuildTimeout);
  }

  rebuildTimeout = setTimeout(() => {
    isRebuilding = true;

    try {
      generateScssIndexFile();
      console.log('✅ SCSSインデックス再生成完了');
    } catch (error) {
      console.error('❌ SCSSインデックス再生成でエラーが発生しました:', error.message);
    } finally {
      isRebuilding = false;
    }
  }, 300);
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
    console.log('🟢 SCSSインデックス監視 スタート');
  })
  .on('add', (filePath) => {
    if (filePath.endsWith('.scss') && !filePath.includes('common.scss')) {
      console.log(`📝 ファイル追加検知: ${filePath}`);
      rebuildScssIndex();
    }
  })
  .on('change', (filePath) => {
    // 監視時には変更は無視（追加と削除のみ対応）
  })
  .on('unlink', (filePath) => {
    if (filePath.endsWith('.scss') && !filePath.includes('common.scss')) {
      console.log(`🗑️  ファイル削除検知: ${filePath}`);
      rebuildScssIndex();
    }
  })
  .on('addDir', (dirPath) => {
    console.log(`📁 ディレクトリ追加検知: ${dirPath}`);
    rebuildScssIndex();
  })
  .on('unlinkDir', (dirPath) => {
    console.log(`🗑️  ディレクトリ削除検知: ${dirPath}`);
    rebuildScssIndex();
  });
