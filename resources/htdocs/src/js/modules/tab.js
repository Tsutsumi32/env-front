/************************************************************
 * タブ機能モジュール
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';
import { fadeIn, fadeOut } from '../utils/fadeAnimation.js';

/**
 * タブ制御クラス
 */
export class TabControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      tabSelector = '.js_tab',
      contentSelector = '.js_tabContent',
      parentSelector = '.js_tabParent',
      activeClass = 'is_active',
      enableFadeAnimation = true,
      fadeDuration = 300,
      fadeDisplay = true,
    } = this.options;

    // タブの親要素を取得
    const tabParents = document.querySelectorAll(parentSelector);

    if (!tabParents.length) {
      console.warn('タブの親要素（js_tabParent）が見つかりません');
      return;
    }

    // 各親要素ごとにタブ機能を初期化
    tabParents.forEach((parent) => {
      // 親要素内でのみタブとコンテンツを検索
      const tabs = parent.querySelectorAll(tabSelector);
      const contents = parent.querySelectorAll(contentSelector);

      if (!tabs.length || !contents.length) {
        console.warn('タブまたはコンテンツが見つかりません', parent);
        return;
      }

      // 各タブにクリックイベントを追加
      tabs.forEach((tab) => {
        tab.addEventListener(
          'click',
          (e) => {
            e.preventDefault();
            const targetTab = tab.getAttribute('data-tab');

            if (!targetTab) {
              console.warn('data-tab属性が設定されていません');
              return;
            }

            // 既にアクティブなタブの場合は何もしない
            if (tab.classList.contains(activeClass)) {
              return;
            }

            // コンテンツの表示切替（フェードアニメーション付き）
            if (enableFadeAnimation) {
              // 現在表示中のコンテンツを取得（タブの切り替え前に取得、親要素内でのみ検索）
              const currentContent = parent.querySelector(`${contentSelector}.${activeClass}`);

              // 新しいコンテンツを取得（親要素内でのみ検索）
              const newContent = parent.querySelector(
                `${contentSelector}[data-tab="${targetTab}"]`
              );

              if (currentContent && newContent && currentContent !== newContent) {
                // js_tabParentの高さを取得
                const currentHeight = parent.offsetHeight;

                // js_tabParentの高さを強制的に指定（レイアウト保持）
                parent.style.minHeight = currentHeight + 'px';

                // 高さが確実に適用されるまで待機してから切り替え処理を開始
                requestAnimationFrame(() => {
                  requestAnimationFrame(() => {
                    // 現在のコンテンツをフェードアウト
                    fadeOut(currentContent, fadeDuration, fadeDisplay, signal);

                    // フェードアウト完了後にクラスを切り替え
                    const timeoutId1 = setTimeout(() => {
                      currentContent.classList.remove(activeClass);

                      // 新しいコンテンツを準備
                      newContent.classList.add(activeClass);
                      if (fadeDisplay) {
                        newContent.style.display = 'block';
                        newContent.style.opacity = '0';
                      }

                      // 新しいコンテンツをフェードイン
                      const timeoutId2 = setTimeout(() => {
                        fadeIn(newContent, fadeDuration, fadeDisplay, signal);

                        // フェードイン完了後にjs_tabParentの高さを解除
                        const timeoutId3 = setTimeout(() => {
                          parent.style.height = '';
                        }, fadeDuration);
                        // signalでタイムアウトをクリーンアップ
                        if (signal) {
                          signal.addEventListener('abort', () => clearTimeout(timeoutId3), {
                            once: true,
                          });
                        }
                      }, 50); // 少し遅延を入れてスムーズに
                      // signalでタイムアウトをクリーンアップ
                      if (signal) {
                        signal.addEventListener('abort', () => clearTimeout(timeoutId2), {
                          once: true,
                        });
                      }
                    }, fadeDuration);
                    // signalでタイムアウトをクリーンアップ
                    if (signal) {
                      signal.addEventListener('abort', () => clearTimeout(timeoutId1), {
                        once: true,
                      });
                    }
                  });
                });
              } else if (newContent) {
                // 現在のコンテンツがない場合（初回表示など）
                newContent.classList.add(activeClass);
                if (fadeDisplay) {
                  newContent.style.display = 'block';
                  newContent.style.opacity = '0';
                }
                const timeoutId = setTimeout(() => {
                  fadeIn(newContent, fadeDuration, fadeDisplay, signal);
                }, 50);
                // signalでタイムアウトをクリーンアップ
                if (signal) {
                  signal.addEventListener('abort', () => clearTimeout(timeoutId), { once: true });
                }
              }
            } else {
              // フェードアニメーション無効の場合は従来通り
              contents.forEach((content) => {
                const contentTab = content.getAttribute('data-tab');
                if (contentTab === targetTab) {
                  content.classList.add(activeClass);
                } else {
                  content.classList.remove(activeClass);
                }
              });
            }

            // アクティブタブの切り替え（コンテンツの処理後に実行、親要素内のタブのみ）
            tabs.forEach((t) => t.classList.remove(activeClass));
            tab.classList.add(activeClass);
          },
          { signal }
        );
      });

      // 初期状態の設定（最初のタブをアクティブに）
      const firstTab = tabs[0];
      const firstTabTarget = firstTab.getAttribute('data-tab');

      if (firstTabTarget) {
        firstTab.classList.add(activeClass);
        const firstContent = parent.querySelector(
          `${contentSelector}[data-tab="${firstTabTarget}"]`
        );
        if (firstContent) {
          firstContent.classList.add(activeClass);

          // 初期表示時もフェードアニメーションを適用
          if (enableFadeAnimation) {
            if (fadeDisplay) {
              firstContent.style.display = 'block';
              firstContent.style.opacity = '0';
            }
            // 少し遅延してフェードイン
            const timeoutId = setTimeout(() => {
              fadeIn(firstContent, fadeDuration, fadeDisplay, signal);
            }, 50);
            // signalでタイムアウトをクリーンアップ
            if (signal) {
              signal.addEventListener('abort', () => clearTimeout(timeoutId), { once: true });
            }
          }
        }
      }
    });
  }
}
