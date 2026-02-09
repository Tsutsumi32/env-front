import { spawn, exec } from 'child_process';
import { promisify } from 'util';
import { getEnv } from '../load-env.js';
import { BUILD_CONFIG } from '../../build-config.js';

const execAsync = promisify(exec);

/**
 * 既存のブラウザシンクプロセスを終了
 * 現在のプロセス（自分自身）は除外する
 */
async function killExistingBrowserSync() {
  try {
    const currentPid = process.pid;
    // ブラウザシンクプロセスを検索（現在のプロセスを除外）
    const { stdout } = await execAsync(`pgrep -f "browser-sync" || true`);
    if (stdout.trim()) {
      const pids = stdout.trim().split('\n').filter(pid => {
        const pidNum = parseInt(pid.trim());
        // 現在のプロセスとその親プロセスを除外
        return pidNum !== currentPid && pidNum !== process.ppid;
      });

      if (pids.length > 0) {
        for (const pid of pids) {
          try {
            await execAsync(`kill -9 ${pid} 2>/dev/null || true`);
          } catch (error) {
            // プロセスが既に終了している場合は無視
          }
        }
        console.log('🔄 既存のブラウザシンクプロセスを終了しました');
      }
    }
  } catch (error) {
    // プロセスが存在しない場合はエラーを無視
    // console.log('既存のブラウザシンクプロセスは見つかりませんでした');
  }
}

/**
 * 指定されたポートを使用しているプロセスを終了
 * 現在のプロセス（自分自身）は除外する
 * @param {string} port - ポート番号
 */
async function killProcessOnPort(port) {
  try {
    const currentPid = process.pid;
    // lsofでポートを使用しているプロセスを検索して終了
    // lsofが利用できない環境でもエラーにならないようにする
    try {
      const { stdout } = await execAsync(`lsof -ti:${port} 2>/dev/null || true`);
      if (stdout.trim()) {
        const pids = stdout.trim().split('\n').filter(pid => {
          const pidNum = parseInt(pid.trim());
          // 現在のプロセスとその親プロセスを除外
          return pidNum !== currentPid && pidNum !== process.ppid && pid;
        });

        if (pids.length > 0) {
          for (const pid of pids) {
            try {
              await execAsync(`kill -9 ${pid} 2>/dev/null || true`);
            } catch (error) {
              // プロセスが既に終了している場合は無視
            }
          }
          console.log(`🔄 ポート ${port} を使用していたプロセスを終了しました`);
        }
      }
    } catch (error) {
      // lsofが利用できない環境では、fuserを試す（Linux環境）
      // ただし、fuserは現在のプロセスを除外できないため、より慎重に
      try {
        // fuserは使用しない（現在のプロセスも終了してしまう可能性があるため）
        // await execAsync(`fuser -k ${port}/tcp 2>/dev/null || true`);
      } catch (error) {
        // 無視
      }
    }
  } catch (error) {
    // ポートが使用されていない場合はエラーを無視
  }
}

/**
 * ブラウザシンクを起動
 */
async function startBrowserSync() {
  // ポートは環境変数から取得（docker-compose.ymlで使用）
  const port = getEnv('FRONT_PORT', '3000');
  // その他の設定は定数から取得
  const proxyTarget = BUILD_CONFIG.BROWSER_SYNC_PROXY;
  const watchDir = BUILD_CONFIG.BROWSER_SYNC_WATCH_DIR;

  // 既存のプロセスを終了
  await killExistingBrowserSync();
  await killProcessOnPort(port);

  // 少し待ってから起動（プロセス終了の完了を待つ）
  await new Promise(resolve => setTimeout(resolve, 500));

  // 監視するファイルパターン（ディレクトリ部分のみ環境変数で管理）
  const watchFilesArray = [
    `${watchDir}/*.html`,
    `${watchDir}/*.php`,
    `${watchDir}/**/*.html`,
    `${watchDir}/**/*.php`,
    `${watchDir}/**/*.css`,
    `${watchDir}/**/*.js`
  ];

  // ブラウザシンクの起動コマンドを構築
  const browserSyncArgs = ['browser-sync', 'start'];

  if (proxyTarget) {
    // プロキシモード：BROWSER_SYNC_PROXYが設定されている場合
    console.log(`🚀 Browser Sync starting with proxy: ${proxyTarget}`);
    browserSyncArgs.push('--proxy', proxyTarget);
  } else {
    // サーバーモード：BROWSER_SYNC_PROXYが設定されていない場合
    console.log(`🚀 Browser Sync starting in server mode (${watchDir})`);
    browserSyncArgs.push('--server', watchDir);
  }

  browserSyncArgs.push('--port', port, '--files', watchFilesArray.join(','));

  // ブラウザシンクを起動
  const browserSync = spawn('npx', browserSyncArgs, {
    stdio: 'inherit',
    shell: true
  });

  browserSync.on('error', (error) => {
    console.error(`❌ Browser Sync error: ${error.message}`);
    process.exit(1);
  });

  browserSync.on('exit', (code) => {
    if (code !== 0) {
      console.error(`❌ Browser Sync exited with code ${code}`);
      process.exit(code);
    }
  });
}

// ブラウザシンクを起動
startBrowserSync();
