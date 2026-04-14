<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h2>ログイン</h2>
  <form method="POST" action="/login">
    @csrf
    <label>メールアドレス</label>
    <input type="email" name="email">
    <label>パスワード</label>
    <input type="password" name="password">
    <button type="submit">ログイン</button>
</form>
<a  href="/register">会員登録はこちら</a>
</body>
</html>