document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contactForm');
  const errorMessage = document.getElementById('errorMessage');
  const successMessage = document.getElementById('successMessage');

  // URLパラメータから成功・エラーメッセージを取得して表示
  const urlParams = new URLSearchParams(window.location.search);
  const success = urlParams.get('success');
  const error = urlParams.get('error');

  if (success === 'true') {
      successMessage.textContent = 'お問い合わせありがとうございます。送信が完了しました。';
  }

  if (error) {
      errorMessage.innerHTML = decodeURIComponent(error).replace(/\+/g, ' ');
  }

  form.addEventListener('submit', function(event) {
      event.preventDefault();

      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const subject = document.getElementById('subject').value.trim();
      const message = document.getElementById('message').value.trim();

      errorMessage.textContent = '';
      successMessage.textContent = '';

      if (!name) {
          errorMessage.textContent = 'お名前を入力してください。';
          return;
      }

      if (!email) {
          errorMessage.textContent = 'メールアドレスを入力してください。';
          return;
      } else if (!isValidEmail(email)) {
          errorMessage.textContent = '有効なメールアドレスを入力してください。';
          return;
      }

      if (!subject) {
          errorMessage.textContent = '件名を入力してください。';
          return;
      }

      if (!message) {
          errorMessage.textContent = 'お問い合わせ内容を入力してください。';
          return;
      }

      form.submit();
  });

  function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
  }
});