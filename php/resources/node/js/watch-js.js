// watch-js.js
import chokidar from 'chokidar';
import path from 'path';
import { runLintAll, buildJs, buildJsSingle, ENTRY_DIRS } from './logic-js.js';
import { BUILD_CONFIG } from '../../build-config.js';

const JS_CONFIG = BUILD_CONFIG.JS;

const watchPaths = [
  JS_CONFIG.DIR_SRC, // 再帰的に全 .js を監視
];

let buildTimeout = null;
let lintTimeout = null;

/**
 * 変更ファイルが ENTRY_DIRS いずれかの直下の .js（個別コンパイル対象）かどうか
 */
function isEntryFile(filePath) {
  const normalized = path.normalize(path.resolve(filePath));
  for (const entryDir of ENTRY_DIRS) {
    const dirNormalized = path.normalize(path.resolve(entryDir));
    if (!normalized.startsWith(dirNormalized + path.sep) && normalized !== dirNormalized) {
      continue;
    }
    const rel = path.relative(dirNormalized, normalized);
    if (!rel.startsWith('..') && path.dirname(rel) === '.' && rel.endsWith('.js')) {
      return true;
    }
  }
  return false;
}

function handleChange(filePath) {
  if (!filePath.endsWith('.js')) return;

  if (buildTimeout) clearTimeout(buildTimeout);
  if (lintTimeout) clearTimeout(lintTimeout);

  buildTimeout = setTimeout(async () => {
    if (isEntryFile(filePath)) {
      console.log(`📝 コンパイル: ${path.basename(filePath)}`);
      await buildJsSingle(filePath);
    } else {
      // ENTRY_DIRS 以外（utils, modules, core 等）の変更時は全エントリをコンパイル
      console.log(`🔄 依存変更: 全エントリをコンパイル`);
      await buildJs();
    }
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
