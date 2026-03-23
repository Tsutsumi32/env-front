/********************************************************************/
/* お問合せフォーム関連処理
/********************************************************************/

document.addEventListener("DOMContentLoaded", () => {
  // 同意チェックボックスの動作
  const policyCheckItem = document.querySelector('.js_agreeCheck input');
  const policyCheckLabel = document.querySelector('.js_formCheckLabel');
  if(policyCheckItem) {
    policyCheckItem.setAttribute('id', 'cbPolicy');
    policyCheckItem.addEventListener('change', e => {
      if(policyCheckItem.checked) {
        policyCheckLabel.classList.add('is_active');
      } else {
        policyCheckLabel.classList.remove('is_active');
      }
    })
  }

  // 同意チェックボックスのラベル機能
  document.getElementById('policyCheckLabel').addEventListener('click', function(e) {
    if (policyCheckItem && policyCheckItem.type === 'checkbox') {
      policyCheckItem.checked = !policyCheckItem.checked;
      if(policyCheckItem.checked) {
        policyCheckLabel.classList.add('is_active');
      } else {
        policyCheckLabel.classList.remove('is_active');
      }
    }
  });

  // ファイル選択
  const fileInput = document.querySelector('.js_formFileInput');
  // 選択時のテキスト表示
  if(fileInput) {
    const fileName = document.querySelector('.js_formFileName');
    const fileClearButton = document.querySelector('.js_formFileTrash');
    const fileNameInitial = fileName.textContent;

    fileInput.addEventListener('change', function () {
      if(fileInput.files.length > 0) {
        fileName.textContent = fileInput.files[0].name;
        fileClearButton.style.display = 'block';
      } else {
        fileName.textContent = '';
        fileClearButton.style.display = 'none';
      }
    });
    // 削除ボタン処理
    fileClearButton.addEventListener('click', function () {
      fileInput.value = '';
      fileName.textContent = fileNameInitial;
      fileClearButton.style.display = '';
    });
  }
});

/**
 * バリデーション　必須項目
 * @param {String} val 入力値
 * @param {String} subject メッセージに付与するラベル
 * @param {String} subject メッセージの語尾
 * @returns {String} エラー文字列
 */
const validateRequire = (val, subject = '', message = '入力してください。') => {
  let result = false;
  if(subject) {
    subject += 'を';
  }
  if (!val.trim()) {
    result = `${subject}${message}`;
  }
  return result;
}

/**
 * バリデーション　メールアドレス
 * @param {String} val 入力値
 * @returns {String} エラー文字列
 */
const validateEMail = val => {
  let result = false;
  const emailPattern = /^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
  if(val.trim()) {
    if(!emailPattern.test(val)) {
      result = '有効なメールアドレスを入力してください。'
    }
  }
  return result;
}

/**
 * バリデーション　電話番号
 * @param {String} val 入力値
 * @returns {String} エラー文字列
 */
const validateTel = val => {
  let result = false;
  const telPattern = /^(\d{2,4}-?\d{2,4}-?\d{4})$/;
  if(val.trim()) {
    if(!telPattern.test(val)) {
      result = '正しい形式の番号を入力してください。'
    }
  }
  return result;
}

/**
 * バリデーション　カタカナ
 * @param {String} val 入力値
 * @returns {String} エラー文字列
 */
const validateKatakana = val => {
  let result = false;
  const telPattern = /^[ァ-ヶー　]+$/;
  if(val.trim()) {
    if(!telPattern.test(val)) {
      result = '全角カタカナで入力してください。'
    }
  }
  return result;
}

/**
 * バリデーション　ひらがな
 * @param {String} val 入力値
 * @returns {String} エラー文字列
 */
const validateHiragana = val => {
  let result = false;
  const hiraPattern = /^[ぁ-んー　]+$/;
  if(val.trim()) {
    if(!hiraPattern.test(val)) {
      result = '全角ひらがなで入力してください。';
    }
  }
  return result;
}

/**
 * バリデーション　必須チェックボックス
 * @param {String} val 入力値
 * @returns {String} エラー文字列
 */
const validateRequireCheck = val => {
  let result = false;
  if(!val) {
    result = "個人情報の取り扱いについて同意が必要です。"
  }
  return result;
}

/**
 * バリデーション　文字数上限
 * @param {String} val 入力値
 * @param {String} max 文字数上限
 * @param {String} subject メッセージに付与するラベル
 * @returns {String} エラー文字列
 */
const validateMaxLength = (val, max = 80, subject = '') => {
  let result = false;
  if(subject) {
    subject += 'は';
  }
  if (val.trim().length > max) {
    result = `${subject}${max}文字以下で入力してください。`;
  }
  return result;
}

/**
 * バリデーション　ファイル種別
 * @param {String} val 入力値
 * @param {int} maxSizeMb 最大容量
 * @returns {String} エラー文字列
 */
const validateFile= (val, maxSizeMb) => {
  let result = false;
  if(val) {
    // ファイル名
    const fileName = val.name;
    // サイズ
    const fileSize = val.size;
    // ファイル上限サイズ
    const maxSizeBytes = maxSizeMb * 1024 * 1024;
    // 許可する拡張子
    const allowedExtensions = ["pdf", "png", "jpeg", "jpg", "xlsx", "xls", "docx", "doc"];
    // 拡張子を取得（小文字化）
    const fileExtension = fileName.split(".").pop().toLowerCase();
    if(!allowedExtensions.includes(fileExtension)) {
      result = 'pdf・png・jpeg・Excelファイル・Wordファイルのいずれかを選択してください。';
    } else if(fileSize > maxSizeBytes) {
      result = `${maxSizeMb}MB以下のファイルをアップロードしてください。`
    }
  }
  return result;
}

/**
 * バリデーション　郵便番号
 * @param {String} val 入力値
 * @returns {String} エラー文字列
 */
const validateZip = val => {
  let result = false;
  const zipPattern = /^\d{3}-?\d{4}$/;
  if(val.trim()) {
    if(!zipPattern.test(val)) {
      result = '正しい郵便番号を入力してください。'
    }
  }
  return result;
}

/**
 * バリデーション　パスワード
 * @param {String} val 入力値
 * @returns {String} エラー文字列
 */
const validatePassword = val => {
  let result = false;
  const zipPattern = /^\d{3}-?\d{4}$/;
  if(val.trim()) {
    if(!zipPattern.test(val)) {
      result = '正しい郵便番号を入力してください。'
    }
  }
  return result;
}

/**
 * バリデーション　一致確認
 * @param {String} val 入力値 パスワード
 * @param {String} val 入力値 パスワード確認
 * @param {String} message 入力値 対象メッセージ
 * @returns {String} エラー文字列
 */
const validateMatchConfirm = (val, confirm, message) => {
  let result = false;
  if (!(val.trim() === confirm.trim())) {
    result = message + 'と一致していません。'
  }
  return result;
}

/**
 * バリデーション実施
 * @returns {Boolean} エラーがあるかどうか
 */
const validation = () => {
  /** バリデーションエラーがあるかどうか判定する */
  let validateStatus = false;

  // 実施するバリデーションの種類 data-validate属性に該当の文字列をセットする
  // (inputの親タグに付与する(CF7対応のため))
  /** 必須チェック */
  const requireValidate = 'require';
  /** メール形式 */
  const emailValidate = 'email';
  /** 電話番号形式 */
  const telValidate = 'tel';
  /** 最大文字列数 */
  const maxLengthValidate = 'maxLength';
  /** チェックボックス必須 */
  const requireCheckBox = 'requireCheck';
  /** ファイルチェック */
  const fileValidate = 'file';
  /** 郵便番号 */
  const zipValidate = 'zip';
  /** パスワード */
  const passwordValidate = 'password';
  /** 一致確認 */
  const matchValidate = 'match';
  /** カタカナ */
  const katakanaValidate = 'katakana';
  /** カタカナ */
  const hiraganaValidate = 'hiragana';

  /** エラー格納配列 */
  const err = [];
  /** 最初のエラー位置を格納する変数 */
  let scrollPosition = 0;

  /**
   * バリデーションの種類を、項目ごとに管理するオブジェクト
   * キー名: data-input値 フィールド: data-validateを分割した配列
   */
  const validateOptions = {}
  /** data-validate属性がある要素 */
  const validateItem = document.querySelectorAll('[data-validate]');

  // data-validate、data-inputの値を取得し、配列に格納する
  validateItem.forEach(item => {
    const validateAttribute = item.getAttribute('data-validate');
    const inputAttribute = item.getAttribute('data-input');
    // data-validateに設定した種別を配列にする
    const validateArray = validateAttribute.split(" ");
    // 上記配列を、バリデーションの種類を管理する配列にpush
    validateOptions[inputAttribute] = validateArray;
  });

  // バリデーション処理(1つ1つの入力欄でループ)
  Object.keys(validateOptions).forEach(key => {
    // エラー配列を初期化
    err.length = 0;
    // 該当項目の入力値
    let value = "";
    // data-inputの値(key)に該当する要素を取得
    const targetItemArray = Array.from(validateItem).filter(item =>
      item.getAttribute('data-input') === key
    );
    const targetItem = targetItemArray[0];
    // inputのタイプによって、値を取得する
    if(targetItem) {
      value = getInputValue(targetItem);
    }

    // 該当の項目のラベル(data-label)
    let targetItemLabel = targetItem.getAttribute('data-label');
    // 該当要素の、data-validateの数分、バリデーション実施
    validateOptions[key].forEach(validate => {
      // 本項目にエラーがあるか
      let isError = false;
      // エラー結果
      let result = '';
      if(validate === requireValidate) {
        if(
          targetItem.querySelector('select')
          || targetItem.querySelector('input[type="radio"]')
          || targetItem.querySelector('input[type="checkbox"]')
        ) {
          result = validateRequire(value, targetItemLabel, '選択してください。');
        } else {
          result = validateRequire(value, targetItemLabel);
        }
        if(result) {
          isError = true;
        }
      } else if(validate === emailValidate) {
        result = validateEMail(value);
        if(result) {
          isError = true;
        }
      } else if(validate === telValidate) {
        result = validateTel(value);
        if(result) {
          isError = true;
        }
      } else if(validate === katakanaValidate) {
        result = validateKatakana(value);
        if(result) {
          isError = true;
        }
      } else if(validate === hiraganaValidate) {
        result = validateHiragana(value);
        if(result) {
          isError = true;
        }
      } else if(validate === maxLengthValidate) {
        // 最大文字数を取得する(data-max属性に最大文字数をセット)
        const max = targetItem.getAttribute('data-max');
        result = validateMaxLength(value, max, targetItemLabel);
        if(result) {
          isError = true;
        }
      } else if(validate === requireCheckBox) {
        result = validateRequireCheck(value);

        if(result) {
          isError = true;
        }
      } else if(validate === fileValidate) {
        const maxSizeMb = targetItem.getAttribute('data-maxSize');
        result = validateFile(value, maxSizeMb);
        if(result) {
          isError = true;
        }
      } else if(validate === zipValidate) {
        result = validateZip(value);
        if(result) {
          isError = true;
        }
      } else if (validate === matchValidate) {
        const thisMatchData = document.querySelector(`[data-input="${key}"]`).getAttribute('data-match');
        const compareItem = document.querySelector(`[data-input="${thisMatchData}"]`);
        const compareText = getInputValue(compareItem);
        const result = validateMatchConfirm(value, compareText, targetItemLabel);
        if (result) {
          isError = true;
        }
      }
      if(isError) {
        err.push('※' + result);
      }
    });

    // 該当のエラー表示エリア
    const targetValidateArea = document.querySelector(`[data-err = "${key}"]`);
    if(targetValidateArea) {
      if(err.length > 0) {
        // エラー表示(最初のエラー)
        targetValidateArea.innerText = err[0];
        // エラークラス付与
        targetValidateArea.classList.add('is_error');
        // バリデーションフラグtrue
        validateStatus = true;
        if(!scrollPosition) {
          // 初めてのエラー位置を設定
          const header = document.querySelector('header');
          scrollPosition = targetValidateArea.getBoundingClientRect().top + window.scrollY - header.offsetHeight - 100;
          window.scrollTo({ top: scrollPosition, behavior: "smooth" });
        }
      } else {
        // エラーが消えた場合、エラー非表示
        targetValidateArea.innerText = "";
        // エラークラス削除削除
        targetValidateArea.classList.remove('is_error');
      }
    }
  });

  return validateStatus;
}

/**
 * data-input属性を付与した要素の中にあるinputのvalueを取得する
 * @param {HTMLElement} item data-input属性が付与された要素
 * @returns {String} 入力値
 */
const getInputValue = (item) => {
  let this_value = '';
  if(item.getAttribute('data-validate') === 'requireCheck') {
    this_value = item.querySelector('input[type="checkbox"]').checked;
  }
  else if (item.querySelector('textArea')) {
    this_value = item.querySelector('textArea').value;
  } else if (item.querySelector('input[type="radio"]')) {
    const target = item.querySelector('input[type="radio"]:checked');
    if(target) {
      this_value = target.value;
    }
  } else if (item.querySelector('input[type="checkbox"]')) {
    const target = item.querySelector('input[type="checkbox"]:checked');
    if(target) {
      this_value = target.value;
    }
  } else if(item.querySelector('select')) {
    this_value = item.querySelector('select').value;
  } else if (item.querySelector('input[type="file"]')) {
    if(item.querySelector('input[type="file"]').files[0]) {
      this_value = item.querySelector('input[type="file"]').files[0];
    }
  } else if (item.querySelector('input')) {
    this_value = item.querySelector('input').value;
  }
  return this_value;
}

/**
 * 確認画面への切り替え処理
 */
const createPageConfirm = () => {
  // 確認画面へ反映させる入力値の親要素(data-input要素)
  const inputItems = document.querySelectorAll('[data-input]');
  // スクロール位置を上へ
  const header = document.querySelector('header');
  // 入力値を確認コンテンツにセット
  inputItems.forEach(item => {
    // 入力値を取得
    let value = getInputValue(item);
    // data-input属性値を取得
    const data = item.getAttribute('data-input');
    const target = document.querySelector(`[data-confirm="${data}"]`);
    // ファイルの場合は、ファイル名を取得
    if(data === 'file') {
      value = value.name;
      if(!value) {
        value = "";
      }
    }
    // 値をセット
    if(target) {
      target.innerText = value;
    }
  });

  // 表示切り替え
  const initialContents = document.querySelectorAll('.js_formInputPage');
  initialContents.forEach($content => {
    $content.style.display = 'none';
  })
  // スクロール位置
  scrollPosition = document.querySelector('.js_contactSection').getBoundingClientRect().top + window.scrollY - header.offsetHeight;
  setTimeout(() => {
    document.querySelector('#formConfirmPage').style.display = 'block';
    window.scrollTo({ top: scrollPosition });
  }, 200);
};

/**
 * 確認画面から戻る処理
 */
const backContactInput = () => {
  const header = document.querySelector('header');

  document.querySelector('#formConfirmPage').style.display = 'none';
  setTimeout(() => {
    const initialContents = document.querySelectorAll('.js_formInputPage');
    initialContents.forEach($content => {
      $content.style.display = 'block';
    })
    // スクロール位置を上へ
    scrollPosition = document.querySelector('.js_contactSection').getBoundingClientRect().top + window.scrollY - header.offsetHeight;
    window.scrollTo({ top: scrollPosition});
  }, 200);
}

/**
 * 本来の送信ボタン処理
 */
const submitLogic = () => {
  const btn = document.querySelector('.js_submit');
  const loading = document.querySelector('#loading');
  if(loading) {
      loading.style.display = 'block';
      setTimeout(() => {
          btn.click();
      }, 300);
  } else {
    btn.click();
  }
}

// バリデーションエラーがあるかどうか
let validate_check = false;
// 確認ボタン
const confirmBtn = document.querySelector('.js_confirmBtn');
// 確認ボタン押下
if (confirmBtn) {
  confirmBtn.addEventListener('click', () => {
    // バリデーション実施
    validate_check = validation();
    // エラーがなければ確認画面切り替え & php側エラーの非表示
    if(!validate_check) {
      const phpErr = document.querySelector('.js_validateAlert');
      if(phpErr) {
        phpErr.style.display = 'none';
      }
      createPageConfirm();
    }
  })
}

document.addEventListener("DOMContentLoaded", () => {
  // 戻るボタン処理
  const backBtn = document.querySelector('.js_confirmBackBtn');
  if (!backBtn) return;
  backBtn.addEventListener('click', backContactInput);

  // 確認画面の送信ボタン処理
  const submitBtn = document.querySelector('.js_submitBtn');
  submitBtn.addEventListener('click', () => {
    submitBtn.style.pointerEvents = 'none';
    submitLogic();
  })

  // 万が一確認画面からの送信で、WP側のバリデーションエラーが発生した場合
  document.addEventListener('wpcf7invalid', function(event) {
    const loading = document.querySelector('#loading');
    // ローディング非表示
    loading.style.display = 'none';
    // 戻る
    backContactInput();
    // エラー文言の表示
    const errElement = document.querySelector('.js_validateAlert');
    errElement.style.display = 'block';
    // 送信ボタンのpointer-events解除
    const submitBtn = document.querySelector('.js_submitBtn');
    submitBtn.style.pointerEvents = 'auto';
  })

  // 万が一確認画面からの送信で、送信エラーが発生した場合
  document.addEventListener('wpcf7mailfailed', function(event) {
    // エラー時に別ページへリダイレクト
    const currentUrl = window.location.href.replace(/\/+$/, '');
    const newUrl = currentUrl.replace(/[^\/]+$/, 'contact-error');
    window.location.href = newUrl;
  })

  // 確認画面をjsで表示切り替えしている画面について、Enterでの送信を防止する
  // 対象フォームの class や id を必要に応じて調整
  const inputs = Array.from(document.querySelectorAll('input, textarea'))
    .filter(el => el.type !== 'hidden' && !el.disabled);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
      const index = inputs.indexOf(e.target);
      // フォーカスが最後の入力欄じゃなければ次へ
      if (index > -1 && index < inputs.length - 1) {
        e.preventDefault(); // 送信防止
        inputs[index + 1].focus(); // 次の入力へ
      }
    }
  });
});
