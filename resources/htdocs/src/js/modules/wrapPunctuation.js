/************************************************************
 * 句読点をspanタグ（クラスpalt）で囲む処理
 * js_paltクラスがついた要素内の句読点（、と。）を処理対象とする
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';

/**
 * 句読点制御クラス
 * @requires .js_palt - 処理対象の要素
 */
export class WrapPunctuationControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      targetSelector = '.js_palt',
      processedDataAttribute = 'paltProcessed',
      spanClass = 'palt',
      punctuationRegex = /([、。（）])/g,
    } = this.options;

    const elements = document.querySelectorAll(targetSelector);

    if (!elements.length) {
      console.warn('句読点処理対象の要素が見つかりません。');
      return;
    }

    elements.forEach((element) => {
      // 既に処理済みの場合はスキップ
      if (element.dataset[processedDataAttribute] === 'true') {
        return;
      }

      // テキストノードを走査して句読点を囲む
      this.walkTextNodes(element, (textNode) => {
        const text = textNode.textContent;

        if (punctuationRegex.test(text)) {
          const fragment = document.createDocumentFragment();
          let lastIndex = 0;
          let match;

          // 正規表現をリセット
          punctuationRegex.lastIndex = 0;

          while ((match = punctuationRegex.exec(text)) !== null) {
            // 句読点の前のテキストを追加
            if (match.index > lastIndex) {
              fragment.appendChild(document.createTextNode(text.substring(lastIndex, match.index)));
            }

            // 句読点をspanで囲む
            const span = document.createElement('span');
            span.className = spanClass;
            span.style.fontFeatureSettings = '"palt"';
            span.textContent = match[0];
            fragment.appendChild(span);

            lastIndex = match.index + match[0].length;
          }

          // 残りのテキストを追加
          if (lastIndex < text.length) {
            fragment.appendChild(document.createTextNode(text.substring(lastIndex)));
          }

          // 元のテキストノードを置き換え
          textNode.parentNode.replaceChild(fragment, textNode);
        }
      });

      // 処理済みフラグを設定
      element.dataset[processedDataAttribute] = 'true';
    });
  }

  /**
   * 要素内のテキストノードを走査するヘルパーメソッド
   * @param {Node} node - 走査する要素
   * @param {Function} callback - テキストノードに対して実行するコールバック
   */
  walkTextNodes(node, callback) {
    const walker = document.createTreeWalker(node, NodeFilter.SHOW_TEXT, {
      acceptNode: (node) => {
        // 親要素がscript, style, noscriptタグの場合はスキップ
        const parent = node.parentElement;
        if (
          parent &&
          (parent.tagName === 'SCRIPT' ||
            parent.tagName === 'STYLE' ||
            parent.tagName === 'NOSCRIPT')
        ) {
          return NodeFilter.FILTER_REJECT;
        }
        return NodeFilter.FILTER_ACCEPT;
      },
    });

    let textNode;
    const textNodes = [];

    // まず全てのテキストノードを収集
    while ((textNode = walker.nextNode())) {
      textNodes.push(textNode);
    }

    // 収集したテキストノードに対して処理を実行
    textNodes.forEach(callback);
  }
}
