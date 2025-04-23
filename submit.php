<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    // 簡単なサーバーサイドでのバリデーション
    $errors = [];
    if (empty($name)) {
        $errors[] = "お名前は必須です。";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "有効なメールアドレスを入力してください。";
    }
    if (empty($subject)) {
        $errors[] = "件名は必須です。";
    }
    if (empty($message)) {
        $errors[] = "お問い合わせ内容は必須です。";
    }

    if (empty($errors)) {
        // メール送信の設定
        $to = "info@mizuno-office.com"; // あなたのメールアドレスに変更してください
        $mailSubject = "ホームページからのお問い合わせ: " . $subject;
        $mailBody = "お名前: " . $name . "\n";
        $mailBody .= "メールアドレス: " . $email . "\n";
        $mailBody .= "件名: " . $subject . "\n";
        $mailBody .= "お問い合わせ内容:\n" . $message;
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";

        // メールの送信
        if (mail($to, $mailSubject, $mailBody, $headers)) {
            // 成功メッセージをindex.htmlにリダイレクト時に渡す
            header("Location: index.html?success=true");
            exit();
        } else {
            // エラーメッセージをindex.htmlにリダイレクト時に渡す
            header("Location: index.html?error=mail_failed");
            exit();
        }
    } else {
        // バリデーションエラーがあった場合、エラーメッセージをindex.htmlにリダイレクト時に渡す
        $error_string = implode("<br>", $errors);
        header("Location: index.html?error=" . urlencode($error_string));
        exit();
    }
} else {
    // POSTリクエスト以外でアクセスされた場合
    header("Location: index.html");
    exit();
}
?>