/**********************************************
 * ES5変換 + Babel + Terser
 * - fast-glob 依存を削除 → fs/promises で代替
 **********************************************/

import { build } from 'esbuild';
import { exec } from 'child_process';
import { mkdirSync } from 'fs';
import { transformFileAsync } from '@babel/core';
import { minify } from 'terser';
import path from 'path';
import { BUILD_CONFIG } from '../../build-config.js';
import fs from 'fs/promises';

// 設定を定数から取得（build-config の JS でパス連結済み）
const JS_CONFIG = BUILD_CONFIG.JS;
export const OUTPUT_DIR = JS_CONFIG.DIR_DIST;
/** 個別コンパイル対象のディレクトリ配列（ここに含まれる直下の .js がエントリ） */
export const ENTRY_DIRS = JS_CONFIG.ENTRY_DIRS;

// 出力フォルダを確実に作成
export function ensureOutputDir() {
  mkdirSync(OUTPUT_DIR, { recursive: true });
}

// 直下の .js を列挙（再帰しない：元の fast-glob "*.js" と同等）
async function listJsInDir(dir) {
  const entries = await fs.readdir(dir, { withFileTypes: true });
  return entries
    .filter((e) => e.isFile() && e.name.endsWith('.js'))
    .map((e) => path.join(dir, e.name));
}

const esbuildOptions = {
  bundle: true,
  minify: false,
  format: 'iife',
  target: ['es2020'],
  sourcemap: false,
  legalComments: 'none',
  keepNames: false,
  loader: {
    '.css': 'empty' // CSSファイルを無視（SCSSで管理するため）
  }
};

/** 単一ファイルに Babel → Terser を適用 */
async function babelTerserFile(file) {
  const babelResult = await transformFileAsync(file, {
    presets: [['@babel/preset-env', { targets: ['defaults'], useBuiltIns: false }]],
    sourceMaps: false
  });
  if (!babelResult?.code) throw new Error(`Babel Failed: ${file}`);
  const terserResult = await minify(babelResult.code, {
    compress: true,
    mangle: true,
    format: { beautify: false, comments: false }
  });
  if (!terserResult?.code) throw new Error(`Terser Failed: ${file}`);
  await fs.writeFile(file, terserResult.code);
}

/**
 * 単一エントリ（pages配下の1ファイル）のみビルド。watch時用。出力ディレクトリは削除しない。
 */
export async function buildJsSingle(entryFilePath) {
  try {
    ensureOutputDir();
    const entryPath = path.resolve(entryFilePath);

    await build({
      entryPoints: [entryPath],
      outdir: OUTPUT_DIR,
      ...esbuildOptions
    });

    const outputFile = path.join(OUTPUT_DIR, path.basename(entryPath));
    await babelTerserFile(outputFile);

    console.log(`✅ JS build complete: ${path.basename(entryPath)}`);
  } catch (error) {
    console.error(`❌ JS build Error: ${error.message}`);
  }
}

/**
 * 全エントリディレクトリから直下の .js を収集
 */
async function collectEntryFiles() {
  const lists = await Promise.all(ENTRY_DIRS.map((dir) => listJsInDir(dir)));
  return lists.flat();
}

/**
 * JSビルド関数（全エントリ一括・Babel + Terser対応版）
 */
export async function buildJs() {
  try {
    // Step 0: 出力先を事前クリーニング
    await fs.rm(OUTPUT_DIR, { recursive: true, force: true });
    ensureOutputDir();

    // Step 1: エントリーファイル取得（ENTRY_DIRS 各直下の *.js）
    const entryFiles = await collectEntryFiles();
    if (entryFiles.length === 0) {
      console.warn('⚠️ エントリーファイルが見つかりません');
      return;
    }

    // Step 2: esbuildで一括バンドル出力
    await build({
      entryPoints: entryFiles,
      outdir: OUTPUT_DIR,
      ...esbuildOptions
    });

    // Step 3: 出力された各ファイルを順に Babel → Terser
    const outputFiles = await listJsInDir(OUTPUT_DIR);
    for (const file of outputFiles) {
      await babelTerserFile(file);
    }

    console.log(`✅ JS build complete (${outputFiles.length} files)`);
  } catch (error) {
    console.error(`❌ JS build Error: ${error.message}`);
  }
}

/**
 * ESLint 実行（全体）
 */
export function runLintAll() {
  console.log(`📝 ESLint check...: ${JS_CONFIG.DIR_SRC}**/*.js`);
  exec(`npx eslint "${JS_CONFIG.DIR_SRC}**/*.js"`, (error, stdout, stderr) => {
    if (error) {
      console.error('❌ ESLint Error');
      if (stdout) console.log(stdout);
      if (stderr) console.error(stderr);
    } else {
      console.log('✅ ESLint Complete');
    }
  });
}
