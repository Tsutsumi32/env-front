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
  avif: { quality: 90, effort: 4 },
  webp: { quality: 90 },
  compression: { scale: 0.5 } // compression画像の縮小率
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
  const ext = path.extname(relativePath);
  return {
    avif: path.join(OUTPUT_DIRS.avif, baseName + '.avif'),
    webp: path.join(OUTPUT_DIRS.webp, baseName + '.webp'),
    compression: path.join(OUTPUT_DIRS.compression, baseName + ext)
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

// メタ情報をファイルから読み込む
async function loadMeta() {
  if (await fs.pathExists(META_FILE)) {
    imageMeta = await fs.readJSON(META_FILE);
  }
}

// メタ情報をファイルに保存する
async function saveMeta() {
  await fs.writeJSON(META_FILE, imageMeta, { spaces: 2 });
  // Docker環境での権限問題を解決: メタファイルの権限を666に設定
  await fs.chmod(META_FILE, 0o666);
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

    await image.clone().toFormat('avif', CONVERT_OPTIONS.avif).toFile(outputPaths.avif);
    // Docker環境での権限問題を解決: ファイル権限を666に設定
    await fs.chmod(outputPaths.avif, 0o666);
    console.log(`✅ AVIF作成: ${outputPaths.avif}`);

    await image.clone().toFormat('webp', CONVERT_OPTIONS.webp).toFile(outputPaths.webp);
    // Docker環境での権限問題を解決: ファイル権限を666に設定
    await fs.chmod(outputPaths.webp, 0o666);
    console.log(`✅ WebP作成: ${outputPaths.webp}`);

    await image.clone().resize({ width: Math.floor(metadata.width * CONVERT_OPTIONS.compression.scale) }).toFile(outputPaths.compression);
    // Docker環境での権限問題を解決: ファイル権限を666に設定
    await fs.chmod(outputPaths.compression, 0o666);
    console.log(`✅ compressionサイズ作成: ${outputPaths.compression}`);
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
    if (processingFiles.has(filePath)) return;
    processingFiles.add(filePath);
    try {
      await loadMeta();
      const ext = path.extname(filePath).toLowerCase();
      if (!supportedExtensions.includes(ext)) return;

      const stable = await waitUntilFileIsStable(filePath);
      if (!stable) return;

      const changed = await hasImageChanged(filePath);
      if (!changed) return;

      await convertImage(filePath);
      await updateMeta(filePath);
    } finally {
      processingFiles.delete(filePath);
    }
  }, 300));
}

// ファイル削除時の処理（出力削除とメタ情報削除）
export async function handleImageDeleted(filePath) {
  await loadMeta();

  const outputs = getOutputPaths(filePath);
  for (const outputPath of Object.values(outputs)) {
    if (await fs.pathExists(outputPath)) {
      await fs.remove(outputPath);
      console.log(`🗑️ 削除: ${outputPath}`);
      await removeEmptyDirsUp(path.dirname(outputPath), path.dirname(Object.values(OUTPUT_DIRS).find(dir => outputPath.startsWith(dir))));
    }
  }

  await removeMeta(filePath);
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
