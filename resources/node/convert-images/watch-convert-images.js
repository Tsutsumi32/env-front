import chokidar from 'chokidar';
import {
  INPUT_DIR,
  handleImageAddedOrChanged,
  handleImageDeleted
} from './logic-convert-images.js';

// chokidar を使用して _origin ディレクトリの変化を監視
chokidar
  .watch(INPUT_DIR, {
    ignored: /(^|[/\\])\\../,
    persistent: true,
    ignoreInitial: true
  })
  .on('ready', () => {
    console.log(`🟢 画像監視開始: ${INPUT_DIR}`);
  })
  .on('add', async (filePath) => {
    console.log(`➕ 追加: ${filePath}`);
    await handleImageAddedOrChanged(filePath);
  })
  .on('change', async (filePath) => {
    // console.log(`✏️ 変更: ${filePath}`);
    await handleImageAddedOrChanged(filePath);
  })
  .on('unlink', async (filePath) => {
    console.log(`🗑️ 削除: ${filePath}`);
    await handleImageDeleted(filePath);
  });
