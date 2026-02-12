/************************************************************
 * 画像ダウンロード（ZIP）
 * - data-action="imgDownload.download" でトリガー
 * - data-feature-imgDownload-img の画像を data-feature-imgDownload-folder の data-feature-imgDownload-folder-name 名で ZIP 化
 ************************************************************/

import { DATA_ATTR } from '../constans/global.js';
import { delegate } from '../utils/delegate.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化。DATA_ATTR.FEATURE は global.js）
// ---------------------------------------------------------------------------
/** 機能名（data-feature の値）。data 属性の値はキャメルケース */
const FEATURE_NAME = 'imgDownload';

const ATTR_IMG = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-img`;
const ATTR_FOLDER = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-folder`;
const ATTR_FOLDER_NAME = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-folderName`;
const ATTR_SRC = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-src`;
const ATTR_NAME = `${DATA_ATTR.FEATURE}-${FEATURE_NAME}-name`;

const SELECTOR_IMG = `[${ATTR_IMG}]`;
const SELECTOR_FOLDER = `[${ATTR_FOLDER}]`;

function getExtensionFromUrl(url) {
  try {
    const pathname = new URL(url).pathname;
    const match = pathname.match(/\.([a-zA-Z0-9]+)(?:\?|$)/);
    if (match?.[1]) return match[1].toLowerCase();
  } catch (_) {}
  const m = String(url).match(/\.([a-zA-Z0-9]+)(?:\?|$)/);
  return m?.[1]?.toLowerCase() ?? 'jpg';
}

/**
 * 画像を ZIP でダウンロード
 */
async function downloadImagesAsZip() {
  const images = document.querySelectorAll(SELECTOR_IMG);
  const folderEl = document.querySelector(SELECTOR_FOLDER);
  if (!folderEl) return;

  const folderName = folderEl.getAttribute(ATTR_FOLDER_NAME) || 'images';
  const JSZip = window.JSZip;
  const saveAs = window.saveAs;
  if (!JSZip || !saveAs) {
    console.warn('JSZip または saveAs が読み込まれていません。');
    return;
  }

  const zip = JSZip().folder(folderName);
  let i = 0;
  for (const img of images) {
    const url = img.getAttribute(ATTR_SRC);
    const name = img.getAttribute(ATTR_NAME);
    const ext = getExtensionFromUrl(url || '');
    const filename = (name ? `${name}-${i + 1}` : `image-${i + 1}`) + `.${ext}`;
    try {
      const res = await fetch(url);
      const blob = await res.blob();
      zip.file(filename, blob);
    } catch (e) {
      console.error(`画像の取得に失敗しました: ${url}`, e);
    }
    i++;
  }

  const content = await zip.generateAsync({ type: 'blob' });
  saveAs(content, `${folderName}.zip`);
}

/**
 * 初期化（document に delegate。data-action="imgDownload.download" をトリガーに）
 * @param {{ scope: { signal: AbortSignal } }} ctx
 */
const init = ({ scope }) => {
  delegate(document, scope, {
    'imgDownload.download': () => downloadImagesAsZip(),
  });
};

export const imgDownload = { init };
