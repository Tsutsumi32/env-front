/************************************************************
 * バリデーション
 ************************************************************/
import { BaseModuleClass } from '../core/BaseModuleClass.js';

// ---------------------------------------------------------------------------
// data 属性（参照するものは定数で一覧化）
// ---------------------------------------------------------------------------
const ATTR_FORM = 'data-form';
const FORM_CONTACT = 'contact';
const ATTR_FORM_SUBMIT = 'data-form-submit';
const ATTR_VALIDATE = 'data-validate';
const ATTR_INPUT = 'data-input';
const ATTR_LABEL = 'data-label';
const ATTR_MAX = 'data-max';
const ATTR_MAX_SIZE = 'data-maxSize';
const ATTR_ERR = 'data-err';

const SELECTOR_FORM_CONTACT = `[${ATTR_FORM}="${FORM_CONTACT}"]`;
const SELECTOR_FORM_SUBMIT = `[${ATTR_FORM_SUBMIT}]`;
const SELECTOR_VALIDATE = `[${ATTR_VALIDATE}]`;

/**
 * フォーム送信処理
 * @param {Event} event - フォーム送信イベント
 * @param {Object} options - オプション設定
 * @param {Boolean} options.useRecaptcha - reCAPTCHAチェックを行うかどうか
 * @param {String} options.siteKey - reCAPTCHAのサイトキー
 * @param {String} options.action - reCAPTCHAのアクション
 * @param {String} options.formSelector - フォームのセレクタ
 * @param {String} options.submitBtnSelector - 送信ボタンのセレクタ
 * @returns {Promise<void>}
 */
export const handleFormSubmit = async (event, options = {}) => {
  const {
    formSelector = SELECTOR_FORM_CONTACT,
    submitBtnSelector = SELECTOR_FORM_SUBMIT,
    useRecaptcha = false,
    siteKey = "",
    action = ""
  } = options;

  const form = document.querySelector(formSelector);
  const submitBtn = document.querySelector(submitBtnSelector);

  // バリデーションエラーがあるかどうか
  let validate_check = false;

  // バリデーション実施
  validate_check = validation(options);

  // バリデーション結果に応じて処理を分岐
  if (!validate_check && form) {
    // バリデーション成功時の処理
    handleValidationSuccess();
  } else {
    // バリデーションエラーあり
    handleValidationError();
  }
};

/**
 * バリデーション　必須項目
 * @param {String|Boolean|File|null} val - 入力値
 * @param {String} subject - メッセージに付与するラベル
 * @param {String} message - メッセージの語尾（デフォルト: "入力してください。"）
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateRequire = (
  val,
  subject = "",
  message = "入力してください。"
) => {
  let result = false;
  if (subject) {
    subject += "を";
  }
  if (typeof val === "string" && !val.trim()) {
    result = `${subject}${message}`;
  } else if (!val) {
    result = `${subject}${message}`;
  }
  return result;
};

/**
 * バリデーション　メールアドレス
 * @param {String} val - 入力値
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateEMail = (val) => {
  let result = false;
  const emailPattern =
    /^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
  if (val.trim()) {
    if (!emailPattern.test(val)) {
      result = "有効なメールアドレスを入力してください。";
    }
  }
  return result;
};

/**
 * バリデーション　電話番号
 * @param {String} val - 入力値
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateTel = (val) => {
  let result = false;
  const telPattern = /^(\d{2,4}-?\d{2,4}-?\d{4})$/;
  if (val.trim()) {
    if (!telPattern.test(val)) {
      result = "正しい形式の番号を入力してください。";
    }
  }
  return result;
};

/**
 * バリデーション　カタカナ
 * @param {String} val - 入力値
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateKatakana = (val) => {
  let result = false;
  const telPattern = /^[ァ-ヶー　]+$/;
  if (val.trim()) {
    if (!telPattern.test(val)) {
      result = "全角カタカナで入力してください。";
    }
  }
  return result;
};

/**
 * バリデーション　ひらがな
 * @param {String} val - 入力値
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateHiragana = (val) => {
  let result = false;
  const hiraPattern = /^[ぁ-んー　]+$/;
  if (val.trim()) {
    if (!hiraPattern.test(val)) {
      result = "全角ひらがなで入力してください。";
    }
  }
  return result;
};

/**
 * バリデーション　必須チェックボックス
 * @param {Boolean} val - チェックボックスの状態
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateRequireCheck = (val) => {
  let result = false;
  if (!val) {
    result = "個人情報の取り扱いについて同意が必要です。";
  }
  return result;
};

/**
 * バリデーション　文字数上限
 * @param {String} val - 入力値
 * @param {Number} max - 文字数上限（デフォルト: 80）
 * @param {String} subject - メッセージに付与するラベル
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateMaxLength = (
  val,
  max = 80,
  subject = ""
) => {
  let result = false;
  if (subject) {
    subject += "は";
  }
  if (val.trim().length > max) {
    result = `${subject}${max}文字以下で入力してください。`;
  }
  return result;
};

/**
 * バリデーション　ファイル種別
 * @param {File|null} val - ファイルオブジェクト
 * @param {Number} maxSizeMb - 最大容量（MB）
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateFile = (
  val,
  maxSizeMb
) => {
  let result = false;
  if (val) {
    // ファイル名
    const fileName = val.name;
    // サイズ
    const fileSize = val.size;
    // ファイル上限サイズ
    const maxSizeBytes = maxSizeMb * 1024 * 1024;
    // 許可する拡張子
    const allowedExtensions = [
      "pdf",
      "png",
      "jpeg",
      "jpg",
      "xlsx",
      "xls",
      "docx",
      "doc",
    ];
    // 拡張子を取得（小文字化）
    const fileExtension = fileName.split(".").pop()?.toLowerCase();
    if (fileExtension && !allowedExtensions.includes(fileExtension)) {
      result =
        "pdf・png・jpeg・Excelファイル・Wordファイルのいずれかを選択してください。";
    } else if (fileSize > maxSizeBytes) {
      result = `${maxSizeMb}MB以下のファイルをアップロードしてください。`;
    }
  }
  return result;
};

/**
 * バリデーション　郵便番号
 * @param {String} val - 入力値
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validateZip = (val) => {
  let result = false;
  const zipPattern = /^\d{3}-?\d{4}$/;
  if (val.trim()) {
    if (!zipPattern.test(val)) {
      result = "正しい郵便番号を入力してください。";
    }
  }
  return result;
};

/**
 * バリデーション　パスワード
 * @param {String} val - 入力値
 * @returns {String|false} エラー文字列、エラーがない場合はfalse
 */
const validatePassword = (val) => {
  let result = false;
  const zipPattern = /^\d{3}-?\d{4}$/;
  if (val.trim()) {
    if (!zipPattern.test(val)) {
      result = "正しい郵便番号を入力してください。";
    }
  }
  return result;
};

/**
 * data-input属性を付与した要素の中にあるinputのvalueを取得する
 * @param {Element} item - data-input属性が付与された要素
 * @returns {String|Boolean|File|null} 入力値
 */
const getInputValue = (item) => {
  let this_value = "";
  if (item.getAttribute(ATTR_VALIDATE) === "requireCheck") {
    const checkbox = item.querySelector(
      'input[type="checkbox"]'
    );
    this_value = checkbox ? checkbox.checked : false;
  } else if (item.querySelector("textArea")) {
    const textarea = item.querySelector("textArea");
    this_value = textarea ? textarea.value : "";
  } else if (item.querySelector('input[type="radio"]')) {
    const target = item.querySelector(
      'input[type="radio"]:checked'
    );
    if (target) {
      this_value = target.value;
    }
  } else if (item.querySelector('input[type="checkbox"]')) {
    const target = item.querySelector(
      'input[type="checkbox"]:checked'
    );
    if (target) {
      this_value = target.value;
    }
  } else if (item.querySelector("select")) {
    const select = item.querySelector("select");
    this_value = select ? select.value : "";
  } else if (item.querySelector('input[type="file"]')) {
    const fileInput = item.querySelector(
      'input[type="file"]'
    );
    if (fileInput && fileInput.files && fileInput.files[0]) {
      this_value = fileInput.files[0];
    }
  } else if (item.querySelector("input")) {
    const input = item.querySelector("input");
    this_value = input ? input.value : "";
  }
  return this_value;
};

/**
 * バリデーション実施
 * @param {Object} options - オプション設定
 * @param {String} options.validateSelector - バリデーション対象のセレクタ
 * @param {String} options.errorClass - エラークラス名
 * @param {String} options.headerSelector - ヘッダーのセレクタ
 * @param {Number} options.scrollOffset - スクロールオフセット
 * @returns {Boolean} エラーがある場合true、ない場合false
 */
const validation = (options = {}) => {
  const {
    validateSelector = SELECTOR_VALIDATE,
    errorClass = "is_error",
    headerSelector = "header",
    scrollOffset = 160
  } = options;
  /** バリデーションエラーがあるかどうか判定する */
  let validateStatus = false;

  // 実施するバリデーションの種類 data-validate属性に該当の文字列をセットする
  // (inputの親タグに付与する(CF7対応のため))
  /** 必須チェック */
  const requireValidate = "require";
  /** メール形式 */
  const emailValidate = "email";
  /** 電話番号形式 */
  const telValidate = "tel";
  /** 最大文字列数 */
  const maxLengthValidate = "maxLength";
  /** チェックボックス必須 */
  const requireCheckBox = "requireCheck";
  /** ファイルチェック */
  const fileValidate = "file";
  /** 郵便番号 */
  const zipValidate = "zip";
  /** パスワード */
  const passwordValidate = "password";
  /** 一致確認 */
  const matchValidate = "match";
  /** カタカナ */
  const katakanaValidate = "katakana";
  /** カタカナ */
  const hiraganaValidate = "hiragana";

  /** エラー格納配列 */
  const err = [];
  /** 最初のエラー位置を格納する変数 */
  let scrollPosition = 0;

  /**
   * バリデーションの種類を、項目ごとに管理するオブジェクト
   * キー名: data-input値 フィールド: data-validateを分割した配列
   */
  const validateOptions = {};
  /** data-validate属性がある要素 */
  const validateItem = document.querySelectorAll(validateSelector);

  // data-validate、data-inputの値を取得し、配列に格納する
  validateItem.forEach((item) => {
    const validateAttribute = item.getAttribute(ATTR_VALIDATE);
    const inputAttribute = item.getAttribute(ATTR_INPUT);
    if (validateAttribute && inputAttribute) {
      // data-validateに設定した種別を配列にする
      const validateArray = validateAttribute.split(" ");
      // 上記配列を、バリデーションの種類を管理する配列にpush
      validateOptions[inputAttribute] = validateArray;
    }
  });

  // バリデーション処理(1つ1つの入力欄でループ)
  Object.keys(validateOptions).forEach((key) => {
    // エラー配列を初期化
    err.length = 0;
    // 該当項目の入力値
    let value = "";
    // data-inputの値(key)に該当する要素を取得
    const targetItemArray = Array.from(validateItem).filter(
      (item) => item.getAttribute(ATTR_INPUT) === key
    );
    const targetItem = targetItemArray[0];
    // inputのタイプによって、値を取得する
    if (targetItem) {
      value = getInputValue(targetItem);
    }

    // 該当の項目のラベル(data-label)
    let targetItemLabel = targetItem?.getAttribute(ATTR_LABEL) || "";
    // 該当要素の、data-validateの数分、バリデーション実施
    validateOptions[key].forEach((validate) => {
      // 本項目にエラーがあるか
      let isError = false;
      // エラー結果
      let result = false;
      if (validate === requireValidate) {
        if (
          targetItem?.querySelector("select") ||
          targetItem?.querySelector('input[type="radio"]') ||
          targetItem?.querySelector('input[type="checkbox"]')
        ) {
          result = validateRequire(
            value,
            targetItemLabel,
            "選択してください。"
          );
        } else {
          result = validateRequire(value, targetItemLabel);
        }
        if (result) {
          isError = true;
        }
      } else if (validate === emailValidate) {
        result = validateEMail(value);
        if (result) {
          isError = true;
        }
      } else if (validate === telValidate) {
        result = validateTel(value);
        if (result) {
          isError = true;
        }
      } else if (validate === katakanaValidate) {
        result = validateKatakana(value);
        if (result) {
          isError = true;
        }
      } else if (validate === hiraganaValidate) {
        result = validateHiragana(value);
        if (result) {
          isError = true;
        }
      } else if (validate === maxLengthValidate) {
        // 最大文字数を取得する(data-max属性に最大文字数をセット)
        const max = targetItem?.getAttribute(ATTR_MAX);
        result = validateMaxLength(
          value,
          max ? parseInt(max) : 80,
          targetItemLabel
        );
        if (result) {
          isError = true;
        }
      } else if (validate === requireCheckBox) {
        result = validateRequireCheck(value);

        if (result) {
          isError = true;
        }
      } else if (validate === fileValidate) {
        const maxSizeMb = targetItem?.getAttribute(ATTR_MAX_SIZE);
        result = validateFile(
          value,
          maxSizeMb ? parseInt(maxSizeMb) : 10
        );
        if (result) {
          isError = true;
        }
      } else if (validate === zipValidate) {
        result = validateZip(value);
        if (result) {
          isError = true;
        }
      }
      if (isError && result) {
        err.push("※" + result);
      }
    });

    // 該当のエラー表示エリア
    const targetValidateArea = document.querySelector(
      `[${ATTR_ERR} = "${key}"]`
    );
    if (targetValidateArea) {
      if (err.length > 0) {
        // エラー表示(最初のエラー)
        targetValidateArea.innerText = err[0];
        // エラークラス付与
        if (targetValidateArea.parentElement) {
          targetValidateArea.parentElement.classList.add(errorClass);
        }
        // バリデーションフラグtrue
        validateStatus = true;
        if (!scrollPosition) {
          // 初めてのエラー位置を設定
          const header = document.querySelector(headerSelector);
          if (header) {
            scrollPosition =
              targetValidateArea.getBoundingClientRect().top +
              window.scrollY -
              header.offsetHeight -
              scrollOffset;
            window.scrollTo({ top: scrollPosition, behavior: "smooth" });
          }
        }
      } else {
        // エラーが消えた場合、エラー非表示
        targetValidateArea.innerText = "";
        // エラークラス削除削除
        targetValidateArea.classList.remove(errorClass);
      }
    }
  });

  return validateStatus;
};

/**
 * バリデーション成功時の処理
 * @returns {void}
 */
const handleValidationSuccess = () => {
  console.log("success");

  // フォーム送信処理（SSGFormへ送信）
  // 使用する場合はコメントアウトを解除
  /*
  if (typeof window.FormSubmitHandler !== "undefined") {
    await window.FormSubmitHandler.submitForm(form, submitBtn, useRecaptcha);
  }
  */
};

/**
 * バリデーションエラー時の処理
 * @returns {void}
 */
const handleValidationError = () => {
  console.error("Validation Error !");
};

/************************************************************
 * フォームバリデーション制御クラス
 ************************************************************/

/**
 * フォームバリデーション制御クラス
 */
export class FormValidatorControl extends BaseModuleClass {
  /**
   * 初期化処理
   * @param {HTMLElement} element - 対象要素（このモジュールでは使用しない）
   * @param {Object} resources - リソース
   * @param {Object} resources.bag - disposeBag
   * @param {AbortSignal} resources.signal - AbortSignal
   */
  init(element, { bag, signal }) {
    const {
      formSelector = SELECTOR_FORM_CONTACT,
      submitBtnSelector = SELECTOR_FORM_SUBMIT,
      useRecaptcha = false
    } = this.options;

    const form = document.querySelector(formSelector);
    const submitBtn = document.querySelector(submitBtnSelector);

    if (!form) {
      console.warn('フォーム要素が見つかりません。');
      return;
    }

    if (!submitBtn) {
      console.warn('送信ボタンが見つかりません。');
      return;
    }

    // 送信ボタンにイベントリスナーを追加
    submitBtn.addEventListener('click', (event) => {
      event.preventDefault();
      handleFormSubmit(event, {
        formSelector,
        submitBtnSelector,
        useRecaptcha
      });
    }, { signal });
  }
}


