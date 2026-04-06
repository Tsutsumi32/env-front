/************************************************************
 * リサイズ判定 PC or SP か
 * ブレイクポイントを跨いだ際に実行する処理を制御可能
 ************************************************************/
import { BREAKPOINTS } from '@consts/global.js';

/**
 * PCレイアウトかどうか判定
 * @returns {boolean} PCレイアウトの場合true、SPレイアウトの場合false
 */
export const isPc = () => {
  return window.innerWidth >= BREAKPOINTS.PC ? true : false;
};

/**
 * PC SP 切り替わり時に一度だけ実行する
 * @param {Function} funcPc - PCレイアウト時の実行関数
 * @param {Function} funcSp - SPレイアウト時の実行関数
 * @param {AbortSignal} [signal] - AbortSignal（省略時は MPA 想定で登録のみ・破棄しない）
 */
export const resizeTimingControl = (funcPc, funcSp, signal) => {
  // pc領域かどうか
  let change_pc_check = false;
  isPc() && (change_pc_check = true);
  // sp領域かどうか
  let change_sp_check = false;
  !isPc() && (change_sp_check = true);

  const opts = signal ? { signal } : {};
  window.addEventListener(
    'resize',
    () => {
      if (isPc()) {
        if (change_pc_check === false) {
          funcPc && funcPc();
          change_pc_check = true;
        }
        change_sp_check = false;
      } else {
        if (change_sp_check === false) {
          funcSp && funcSp();
          change_sp_check = true;
        }
        change_pc_check = false;
      }
    },
    opts
  );
};
