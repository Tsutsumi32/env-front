  /**
   * ボタンを送信中状態にする
   * @param {HTMLElement} submitBtn 送信ボタン要素
   */
  const setButtonSubmitting = (submitBtn) => {
    try {
      submitBtn.disabled = true;
      submitBtn.textContent = "送信中...";
    } catch (error) {
      console.error("ボタンの状態変更エラー:", error);
    }
  };

  /**
   * ボタンを通常状態に戻す
   * @param {HTMLElement} submitBtn 送信ボタン要素
   */
  const setButtonNormal = (submitBtn) => {
    try {
      submitBtn.disabled = false;
      submitBtn.textContent = "送信";
    } catch (error) {
      console.error("ボタンの状態変更エラー:", error);
    }
  };

  /**
   * reCAPTCHAチェック処理
   * @param {String} siteKey reCAPTCHAのサイトキー
   * @param {String} action reCAPTCHAのアクション
   * @returns {Promise<Boolean>} 成功したかどうか
   */
  const executeRecaptchaCheck = async (siteKey, action) => {
    if (typeof window.RecaptchaHandler === "undefined") {
      console.warn("RecaptchaHandler not loaded");
      return false;
    }

    try {
      await window.RecaptchaHandler.executeRecaptchaCheck(siteKey, action);
      return true;
    } catch (error) {
      console.error("reCAPTCHAエラー:", error);
      return false;
    }
  };

  /**
   * フォーム送信処理（SSGFormへの送信を含む）
   * @param {HTMLElement} form フォーム要素
   * @param {HTMLElement} submitBtn 送信ボタン要素
   * @param {Boolean} useRecaptcha reCAPTCHAチェックを行うかどうか
   */
  const submitForm = async (form, submitBtn, useRecaptcha = false) => {
    try {
      // ボタンを無効化して二重送信を防止
      setButtonSubmitting(submitBtn);

      // フォームから設定を取得
      const endpoint = form.dataset.endpoint;
      const siteKey = form.dataset.siteKey;
      const action = form.dataset.action;

      if (!endpoint || !siteKey || !action) {
        throw new Error("SSGForm configuration not complete");
      }

      // reCAPTCHAチェック（必要な場合）
      if (useRecaptcha) {
        const recaptchaSuccess = await executeRecaptchaCheck(siteKey, action);
        if (!recaptchaSuccess) {
          throw new Error("reCAPTCHA verification failed");
        }
      }

      // フォームデータを取得
      const formData = new FormData(form);

      // SSGFormエンドポイントに送信
      if (typeof window.SSGFormHandler === "undefined") {
        throw new Error("SSGFormHandler not loaded");
      }

      const response = await window.SSGFormHandler.submitToSSGForm(endpoint, formData);

      if (response.ok) {
        // 成功時は完了画面にリダイレクト
        window.SSGFormHandler.handleSubmissionSuccess();
      } else {
        // エラー時はエラー画面にリダイレクト
        window.SSGFormHandler.handleSubmissionError();
      }
    } catch (error) {
      // ネットワークエラーなどの場合もエラー画面にリダイレクト
      console.error("送信エラー:", error);
      if (typeof window.SSGFormHandler !== "undefined") {
        window.SSGFormHandler.handleSubmissionError();
      }
    } finally {
      // ボタンの状態を元に戻す
      setButtonNormal(submitBtn);
    }
  };

  // エクスポート
  window.FormSubmitHandler = {
    submitForm,
    executeRecaptchaCheck,
    setButtonSubmitting,
    setButtonNormal
  };
