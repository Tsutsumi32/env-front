  // SSGForm関連の定数
  const THANKS_URL = "/contact-success";
  const ERROR_URL = "/contact-error";

  // セッションキーを定義
  const CONTACT_SESSION_KEYS = {
    FORM_SUBMITTED: "contact_form_submitted"
  };

  /**
   * SSGFormエンドポイントにフォームデータを送信する
   * @param {String} endpoint SSGFormエンドポイントURL
   * @param {FormData} formData 送信するフォームデータ
   * @returns {Promise<Response>} レスポンス
   */
  const submitToSSGForm = async (endpoint, formData) => {
    const response = await fetch(endpoint, {
      method: "POST",
      body: formData,
    });
    return response;
  };

  /**
   * フォーム送信成功時の処理
   */
  const handleSubmissionSuccess = () => {
    sessionStorage.setItem(
      CONTACT_SESSION_KEYS.FORM_SUBMITTED,
      "success"
    );
    window.location.href = THANKS_URL;
  };

  /**
   * フォーム送信失敗時の処理
   */
  const handleSubmissionError = () => {
    sessionStorage.setItem(
      CONTACT_SESSION_KEYS.FORM_SUBMITTED,
      "error"
    );
    window.location.href = ERROR_URL;
  };

  // エクスポート
  window.SSGFormHandler = {
    submitToSSGForm,
    handleSubmissionSuccess,
    handleSubmissionError
  };
