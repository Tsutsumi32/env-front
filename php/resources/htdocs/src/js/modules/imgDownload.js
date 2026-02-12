/************************************************************
 * 画像ダウンロード処理
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';

/**
 * URLから拡張子を取得する関数
 * @param {string} url - 画像URL
 * @returns {string} 拡張子（デフォルト: 'jpg'）
 * @private
 */
function getExtensionFromUrl(url) {
  try {
    // URLからパス部分を取得
    const urlObj = new URL(url);
    const pathname = urlObj.pathname;

    // 拡張子を抽出（.jpg, .jpeg, .png, .gif, .webpなど）
    const match = pathname.match(/\.([a-zA-Z0-9]+)(?:\?|$)/);
    if (match && match[1]) {
      return match[1].toLowerCase();
    }
  } catch (error) {
    // URL解析に失敗した場合は、文字列から直接抽出を試みる
    const match = url.match(/\.([a-zA-Z0-9]+)(?:\?|$)/);
    if (match && match[1]) {
      return match[1].toLowerCase();
    }
  }

  // 拡張子が見つからない場合はデフォルトでjpg
  return 'jpg';
}

/**
 * 画像ダウンロード制御クラス
 * @requires [data-img-download] - ダウンロードボタン
 * @requires [data-download-img] - 画像要素（data-src, data-name でURL・ファイル名を指定）
 * @requires [data-download-img-folder] - フォルダ名要素（data-folder でZIP内フォルダ名を指定）
 */
export class ImgDownloadControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      downloadBtnSelector = '[data-img-download]',
      imageSelector = '[data-download-img]',
      folderSelector = '[data-download-img-folder]'
    } = this.options;

    const downloadButton = document.querySelector(downloadBtnSelector);
    if (!downloadButton) {
      console.warn('画像ダウンロードボタン要素が見つかりません。');
      return;
    }

    downloadButton.addEventListener('click', () => {
      this.downloadImagesAsZip({ imageSelector, folderSelector });
    }, { signal });
  }

  /**
   * 画像をZIPファイルとしてダウンロード
   * @param {Object} options - オプション
   * @param {string} options.imageSelector - 画像要素のセレクター
   * @param {string} options.folderSelector - フォルダ名要素のセレクター
   * @private
   */
  async downloadImagesAsZip(options = {}) {
    const {
      imageSelector = '[data-download-img]',
      folderSelector = '[data-download-img-folder]'
    } = options;

    const images = document.querySelectorAll(imageSelector);
    const folderEl = document.querySelector(folderSelector);
    
    if (!folderEl) {
      console.warn('フォルダ名要素が見つかりません。');
      return;
    }

    const folderName = folderEl.getAttribute('data-folder');
    const zip = new JSZip();
    const folder = zip.folder(folderName); // ZIPの中にフォルダ作成

    // for...ofループで順次処理（awaitが正しく動作する）
    let i = 0;
    for (const img of images) {
      const url = img.getAttribute('data-src');
      const name = img.getAttribute('data-name');
      const extension = getExtensionFromUrl(url); // URLから拡張子を取得
      const filename = (name ? `${name}-${i + 1}` : `image-${i + 1}`) + `.${extension}`; // 拡張子を動的に設定

      try {
        const response = await fetch(url);
        const blob = await response.blob();
        folder.file(filename, blob); // フォルダ内にファイル追加
      } catch (error) {
        console.error(`画像の取得に失敗しました: ${url}`, error);
      }
      i++;
    }

    // ZIPファイルを生成してダウンロード
    zip.generateAsync({ type: "blob" }).then(function(content) {
      saveAs(content, `${folderName}.zip`); // 最終的にダウンロードされるZIPファイル名
    });
  }
}

