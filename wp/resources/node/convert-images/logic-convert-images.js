import path from 'path';
import fs from 'fs-extra';
import sharp from 'sharp';
import { BUILD_CONFIG } from '../../build-config.js';

// 設定を定数から取得
const DIR_IMAGE_TARGET_PATH = BUILD_CONFIG.DIR_IMAGE_TARGET_PATH;

// 入力元ディレクトリ（オリジナル画像）
export const INPUT_DIR = path.resolve(`${DIR_IMAGE_TARGET_PATH}_origin`);

// 出力先ディレクトリ（各形式）
export const OUTPUT_DIRS = {
  avif: path.resolve(`${DIR_IMAGE_TARGET_PATH}avif`),
  webp: path.resolve(`${DIR_IMAGE_TARGET_PATH}webp`),
  compression: path.resolve(`${DIR_IMAGE_TARGET_PATH}compression`),
};

// 変換クオリティ等の設定を定数として定義
const CONVERT_OPTIONS = {
  avif: {
    quality: BUILD_CONFIG.IMAGE_CONVERT.AVIF_QUALITY,
    effort: BUILD_CONFIG.IMAGE_CONVERT.AVIF_EFFORT
  },
  webp: {
    quality: BUILD_CONFIG.IMAGE_CONVERT.WEBP_QUALITY
  },
  compression: {
    mode: BUILD_CONFIG.IMAGE_CONVERT.COMPRESSION_MODE,
    width: BUILD_CONFIG.IMAGE_CONVERT.COMPRESSION_WIDTH,
    scale: BUILD_CONFIG.IMAGE_CONVERT.COMPRESSION_SCALE
  }
};

// メタ情報ファイルのパス（変換済みかどうか管理）
export const META_FILE = path.resolve('.image-meta.json');

// 対応画像拡張子
export const supportedExtensions = ['.jpg', '.jpeg', '.png'];

// 変換済み情報を保持するオブジェクト
let imageMeta = {};

// 現在処理中のファイル（重複変換防止用）
const processingFiles = new Set();

// debounce制御用マップ（イベントの連続発火を防ぐ）
const debounceMap = new Map();

// 削除処理用のキューとフラグ
const deleteQueue = [];
let isProcessingDelete = false;

// 削除処理中かどうかを追跡
const deletingFiles = new Set();

// 生成処理用のキューとフラグ
const convertQueue = [];
let isProcessingConvert = false;

// 起動時に入力元と出力先のルートディレクトリを用意する
export async function ensureBaseDirs() {
  await Promise.all([
    fs.ensureDir(INPUT_DIR),
    ...Object.values(OUTPUT_DIRS).map(dir => fs.ensureDir(dir)),
  ]);

  // Docker環境での権限問題を解決: ディレクトリ権限を777に設定
  await Promise.all([
    fs.chmod(INPUT_DIR, 0o777),
    ...Object.values(OUTPUT_DIRS).map(dir => fs.chmod(dir, 0o777)),
  ]);
}

// 変換後の各形式のファイルパスを取得する
export function getOutputPaths(filePath) {
  const relativePath = path.relative(INPUT_DIR, filePath);
  const baseName = relativePath.replace(/\.[^/.]+$/, '');
  const ext = path.extname(relativePath).toLowerCase();

  // compressionの拡張子を統一
  let compressionExt = ext;
  if (ext === '.jpg' || ext === '.jpeg') {
    compressionExt = '.jpg';
  } else if (ext === '.png') {
    compressionExt = '.png';
  }

  return {
    avif: path.join(OUTPUT_DIRS.avif, baseName + '.avif'),
    webp: path.join(OUTPUT_DIRS.webp, baseName + '.webp'),
    compression: path.join(OUTPUT_DIRS.compression, baseName + compressionExt)
  };
}

// 変換先の各ディレクトリが存在するようにする
async function ensureDirs(paths) {
  for (const outputPath of Object.values(paths)) {
    const dirPath = path.dirname(outputPath);
    await fs.ensureDir(dirPath);
    // Docker環境での権限問題を解決: 作成したディレクトリの権限を777に設定
    await fs.chmod(dirPath, 0o777);
  }
}

// メタ情報をファイルから読み込む（リトライ機能付き）
async function loadMeta() {
  const maxRetries = 3;
  let lastError = null;

  for (let i = 0; i < maxRetries; i++) {
    try {
      if (await fs.pathExists(META_FILE)) {
        imageMeta = await fs.readJSON(META_FILE);
        return;
      } else {
        imageMeta = {};
        return;
      }
    } catch (error) {
      lastError = error;
      if (i < maxRetries - 1) {
        // リトライ前に少し待機
        await new Promise(resolve => setTimeout(resolve, 100 * (i + 1)));
      }
    }
  }

  // すべてのリトライが失敗した場合はエラーをスロー
  throw new Error(`メタファイルの読み込みに失敗しました: ${lastError?.message}`);
}

// メタ情報をファイルに保存する（リトライ機能付き）
async function saveMeta() {
  const maxRetries = 3;
  let lastError = null;

  for (let i = 0; i < maxRetries; i++) {
    try {
      await fs.writeJSON(META_FILE, imageMeta, { spaces: 2 });
      // Docker環境での権限問題を解決: メタファイルの権限を666に設定
      await fs.chmod(META_FILE, 0o666);
      return;
    } catch (error) {
      lastError = error;
      if (i < maxRetries - 1) {
        // リトライ前に少し待機
        await new Promise(resolve => setTimeout(resolve, 100 * (i + 1)));
      }
    }
  }

  // すべてのリトライが失敗した場合はエラーをスロー
  throw new Error(`メタファイルの保存に失敗しました: ${lastError?.message}`);
}

// メタ情報のキーを生成する（相対パス）
function getMetaKey(filePath) {
  return path.relative(INPUT_DIR, filePath);
}

// 画像が変更されたかどうかを判定する（mtimeの差分）
async function hasImageChanged(filePath) {
  const stat = await fs.stat(filePath);
  const key = getMetaKey(filePath);
  return !imageMeta[key] || imageMeta[key].mtimeMs !== stat.mtimeMs;
}

// メタ情報を更新する
async function updateMeta(filePath) {
  const stat = await fs.stat(filePath);
  const key = getMetaKey(filePath);
  imageMeta[key] = { mtimeMs: stat.mtimeMs };
  await saveMeta();
}

// メタ情報を削除する
async function removeMeta(filePath) {
  const key = getMetaKey(filePath);
  if (imageMeta[key]) {
    delete imageMeta[key];
    await saveMeta();
  }
}

// Sharpを使って各形式の画像を生成する
export async function convertImage(filePath) {
  try {
    const ext = path.extname(filePath).toLowerCase();
    if (!supportedExtensions.includes(ext)) return;

    const outputPaths = getOutputPaths(filePath);
    await ensureDirs(outputPaths);

    const image = sharp(filePath, { failOnError: false });
    const metadata = await image.metadata();

    // AVIF変換（設定で有効な場合のみ）
    if (BUILD_CONFIG.IMAGE_CONVERT.ENABLE_AVIF) {
      await image.clone().toFormat('avif', CONVERT_OPTIONS.avif).toFile(outputPaths.avif);
      // Docker環境での権限問題を解決: ファイル権限を666に設定
      await fs.chmod(outputPaths.avif, 0o666);
      console.log(`✅ AVIF作成: ${outputPaths.avif}`);
    }

    // WebP変換（設定で有効な場合のみ）
    if (BUILD_CONFIG.IMAGE_CONVERT.ENABLE_WEBP) {
      await image.clone().toFormat('webp', CONVERT_OPTIONS.webp).toFile(outputPaths.webp);
      // Docker環境での権限問題を解決: ファイル権限を666に設定
      await fs.chmod(outputPaths.webp, 0o666);
      console.log(`✅ WebP作成: ${outputPaths.webp}`);
    }

    // compression変換（設定で有効な場合のみ）
    if (BUILD_CONFIG.IMAGE_CONVERT.ENABLE_COMPRESSION) {
      const compressionMode = CONVERT_OPTIONS.compression.mode;
      let resizedImage = image.clone();

      if (compressionMode === 'width') {
        // 横幅指定モード
        const targetWidth = CONVERT_OPTIONS.compression.width;
        if (metadata.width && metadata.width > targetWidth) {
          resizedImage = resizedImage.resize({ width: targetWidth });
        }
        // 元画像が指定幅以下の場合はそのままコピー（リサイズしない）
      } else if (compressionMode === 'scale') {
        // 圧縮率指定モード
        const scale = CONVERT_OPTIONS.compression.scale;
        const targetWidth = Math.floor(metadata.width * scale);
        resizedImage = resizedImage.resize({ width: targetWidth });
      }

      // JPEGの場合は画質設定を適用
      const outputExt = path.extname(outputPaths.compression).toLowerCase();
      if (outputExt === '.jpg' || outputExt === '.jpeg') {
        await resizedImage.toFormat('jpeg', { quality: BUILD_CONFIG.IMAGE_CONVERT.COMPRESSION_JPEG_QUALITY }).toFile(outputPaths.compression);
      } else {
        await resizedImage.toFile(outputPaths.compression);
      }
      // Docker環境での権限問題を解決: ファイル権限を666に設定
      await fs.chmod(outputPaths.compression, 0o666);
      console.log(`✅ compressionサイズ作成: ${outputPaths.compression}`);
    }
  } catch (error) {
    console.error(`❌ 変換失敗: ${filePath}`, error);
  }
}

// ファイルサイズの変化が止まるまで待機する
async function waitUntilFileIsStable(filePath, delay = 300) {
  let lastSize = -1;
  while (true) {
    try {
      const { size } = await fs.stat(filePath);
      if (size === lastSize) return true;
      lastSize = size;
    } catch {
      // 無視して再試行
    }
    await new Promise(res => setTimeout(res, delay));
  }
}

// ファイル追加・変更時の処理（debounceと重複制御付き）
export async function handleImageAddedOrChanged(filePath) {
  clearTimeout(debounceMap.get(filePath));
  debounceMap.set(filePath, setTimeout(async () => {
    // 既に処理中の場合はスキップ
    if (processingFiles.has(filePath)) {
      return;
    }

    // キューに追加
    return new Promise((resolve, reject) => {
      convertQueue.push({ filePath, resolve, reject });
      processConvertQueue();
    });
  }, 300));
}

// 生成キューを順次処理する
async function processConvertQueue() {
  // 既に処理中の場合は何もしない
  if (isProcessingConvert) {
    return;
  }

  isProcessingConvert = true;

  while (convertQueue.length > 0) {
    const { filePath, resolve, reject } = convertQueue.shift();

    // 既に処理中の場合はスキップ
    if (processingFiles.has(filePath)) {
      resolve();
      continue;
    }

    processingFiles.add(filePath);

    try {
      // メタファイルを読み込む
      await loadMeta();

      const ext = path.extname(filePath).toLowerCase();
      if (!supportedExtensions.includes(ext)) {
        processingFiles.delete(filePath);
        resolve();
        continue;
      }

      // ファイルサイズの変化が止まるまで待機
      const stable = await waitUntilFileIsStable(filePath);
      if (!stable) {
        processingFiles.delete(filePath);
        resolve();
        continue;
      }

      // 画像が変更されたかどうかを判定
      const changed = await hasImageChanged(filePath);
      if (!changed) {
        processingFiles.delete(filePath);
        resolve();
        continue;
      }

      // 画像を変換
      await convertImage(filePath);

      // メタ情報を更新
      await updateMeta(filePath);

      processingFiles.delete(filePath);
      resolve();
    } catch (error) {
      console.error(`❌ 変換処理失敗: ${filePath}`, error);
      processingFiles.delete(filePath);
      reject(error);
    }
  }

  isProcessingConvert = false;
}

// ファイル削除時の処理（出力削除とメタ情報削除）
export async function handleImageDeleted(filePath) {
  // 既に削除処理中の場合はスキップ
  if (deletingFiles.has(filePath)) {
    return;
  }

  // キューに追加
  return new Promise((resolve, reject) => {
    deleteQueue.push({ filePath, resolve, reject });
    processDeleteQueue();
  });
}

// 削除キューを順次処理する
async function processDeleteQueue() {
  // 既に処理中の場合は何もしない
  if (isProcessingDelete) {
    return;
  }

  isProcessingDelete = true;

  while (deleteQueue.length > 0) {
    const { filePath, resolve, reject } = deleteQueue.shift();

    // 既に削除処理中の場合はスキップ
    if (deletingFiles.has(filePath)) {
      resolve();
      continue;
    }

    deletingFiles.add(filePath);

    try {
      // メタファイルを読み込む
      await loadMeta();

      const ext = path.extname(filePath).toLowerCase();
      if (!supportedExtensions.includes(ext)) {
        deletingFiles.delete(filePath);
        resolve();
        continue;
      }

      // 出力ファイルを削除
      const outputs = getOutputPaths(filePath);
      for (const outputPath of Object.values(outputs)) {
        if (await fs.pathExists(outputPath)) {
          await fs.remove(outputPath);
          console.log(`🗑️ 削除: ${outputPath}`);
          await removeEmptyDirsUp(path.dirname(outputPath), path.dirname(Object.values(OUTPUT_DIRS).find(dir => outputPath.startsWith(dir))));
        }
      }

      // メタ情報を削除
      await removeMeta(filePath);

      deletingFiles.delete(filePath);
      resolve();
    } catch (error) {
      console.error(`❌ 削除失敗: ${filePath}`, error);
      deletingFiles.delete(filePath);
      reject(error);
    }
  }

  isProcessingDelete = false;
}

// 再帰的にディレクトリ内のすべてのファイルを取得する
export async function getAllFiles(dir) {
  const entries = await fs.readdir(dir, { withFileTypes: true });
  const files = await Promise.all(entries.map(async entry => {
    const res = path.resolve(dir, entry.name);
    return entry.isDirectory() ? await getAllFiles(res) : res;
  }));
  return files.flat();
}

// 空の出力ディレクトリを親階層にさかのぼって削除する
export async function removeEmptyDirsUp(dir, stopAt) {
  if (!dir.startsWith(stopAt)) return;

  const entries = await fs.readdir(dir);
  if (entries.length === 0) {
    await fs.remove(dir);
    console.log(`🗂️ 空ディレクトリ削除: ${dir}`);
    await removeEmptyDirsUp(path.dirname(dir), stopAt);
  }
}
