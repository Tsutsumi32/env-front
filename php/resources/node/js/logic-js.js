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

// 設定を定数から取得
const DIR_SRC_PATH = BUILD_CONFIG.DIR_SRC_PATH;
const DIR_DIST_PATH = BUILD_CONFIG.DIR_DIST_PATH;

export const ENTRY_DIR = `${DIR_SRC_PATH}js/pages`; // 各ページJSがここにある前提
export const OUTPUT_DIR = `${DIR_DIST_PATH}js`;

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

/**
 * JSビルド関数（Babel + Terser対応版）
 */
export async function buildJs() {
  try {
    // Step 0: 出力先を事前クリーニング
    await fs.rm(OUTPUT_DIR, { recursive: true, force: true });
    ensureOutputDir();

    // Step 1: エントリーファイル取得（pages配下直下の *.js）
    const entryFiles = await listJsInDir(ENTRY_DIR);
    if (entryFiles.length === 0) {
      console.warn('⚠️ エントリーファイルが見つかりません');
      return;
    }

    // Step 2: esbuildで一括バンドル出力
    await build({
      entryPoints: entryFiles,
      outdir: OUTPUT_DIR,
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
    });

    // Step 3: 出力された各ファイルを順に Babel → Terser
    const outputFiles = await listJsInDir(OUTPUT_DIR);
    for (const file of outputFiles) {
      const babelResult = await transformFileAsync(file, {
        presets: [['@babel/preset-env', { targets: ['defaults'], useBuiltIns: false }]],
        sourceMaps: false
      });

      if (!babelResult?.code) {
        throw new Error(`Babel Failed: ${file}`);
      }

      const terserResult = await minify(babelResult.code, {
        compress: true,
        mangle: true,
        format: {
          beautify: false,
          comments: false
        }
      });

      if (!terserResult?.code) {
        throw new Error(`Terser Failed: ${file}`);
      }

      await fs.writeFile(file, terserResult.code);
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
  console.log(`📝 ESLint check...: ${DIR_SRC_PATH}js/**/*.js`);
  exec(`npx eslint "${DIR_SRC_PATH}js/**/*.js"`, (error, stdout, stderr) => {
    if (error) {
      console.error('❌ ESLint Error');
      if (stdout) console.log(stdout);
      if (stderr) console.error(stderr);
    } else {
      console.log('✅ ESLint Complete');
    }
  });
}
