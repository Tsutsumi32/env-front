  /**
   * reCAPTCHA v3トークンを取得する
   * @param {String} siteKey reCAPTCHAのサイトキー
   * @param {String} action reCAPTCHAのアクション
   * @returns {Promise<String>} reCAPTCHAトークン
   */
  const getRecaptchaToken = async (siteKey, action) => {
    if (
      typeof window.grecaptcha === "undefined" ||
      !window.grecaptcha.ready
    ) {
      throw new Error("reCAPTCHA not loaded");
    }

    return new Promise((resolve, reject) => {
      window.grecaptcha.ready(() => {
        window.grecaptcha
          .execute(siteKey, { action: action })
          .then((token) => resolve(token))
          .catch((error) => reject(error));
      });
    });
  };

  /**
   * reCAPTCHAトークンをhiddenフィールドに設定する
   * @param {String} token reCAPTCHAトークン
   */
  const setRecaptchaTokenToField = (token) => {
    const recaptchaInput = document.getElementById(
      "g-recaptcha-response"
    );
    if (recaptchaInput) {
      recaptchaInput.value = token;
    }
  };

  /**
   * reCAPTCHAチェック処理（バリデーション成功後に使用）
   * @param {String} siteKey reCAPTCHAのサイトキー
   * @param {String} action reCAPTCHAのアクション
   * @returns {Promise<Boolean>} 成功したかどうか
   */
  const executeRecaptchaCheck = async (siteKey, action) => {
    try {
      const token = await getRecaptchaToken(siteKey, action);
      setRecaptchaTokenToField(token);
      console.log("reCAPTCHAトークンを取得しました");
      return true;
    } catch (error) {
      console.error("reCAPTCHAエラー:", error);
      return false;
    }
  };

  // エクスポート
  window.RecaptchaHandler = {
    getRecaptchaToken,
    setRecaptchaTokenToField,
    executeRecaptchaCheck
  };
