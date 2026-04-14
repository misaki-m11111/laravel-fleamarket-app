<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<h2>会員登録</h2>
<form method="POST" action="/register">
    @csrf
    <label>ユーザー名</label>
    <input type="text" name="name">
    <label>メールアドレス</label>
    <input type="email" name="email">
    <label>パスワード</label>
    <input type="password" name="password">
    <label>確認用パスワード</label>
    <input type="password" name="password_confirmation">
    <button type="submit">登録する</button>
</form>

  <a href="/login">ログインはこちら</a>
</body>
</html>