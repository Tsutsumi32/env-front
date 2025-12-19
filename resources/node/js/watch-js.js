// watch-js.js
import chokidar from 'chokidar';
import { runLintAll, buildJs } from './logic-js.js';
import { BUILD_CONFIG } from '../build-config.js';

// 設定を定数から取得
const DIR_SRC_PATH = BUILD_CONFIG.DIR_SRC_PATH;

const watchPaths = [
  `${DIR_SRC_PATH}js` // ディレクトリ単位でOK（再帰的に全 .js を監視）
];

let buildTimeout = null;
let lintTimeout = null;

function handleChange(filePath) {
  if (!filePath.endsWith('.js')) return;

  if (buildTimeout) clearTimeout(buildTimeout);
  if (lintTimeout) clearTimeout(lintTimeout);

  buildTimeout = setTimeout(() => {
    buildJs();
  }, 200);

  lintTimeout = setTimeout(() => {
    runLintAll();
  }, 250);
}

chokidar
  .watch(watchPaths, {
    ignored: /(^|[/\\])\../,
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
    console.log('🟢 JSファイル監視 スタート');
  })
  .on('add', handleChange)
  .on('change', handleChange)
  .on('unlink', handleChange);
