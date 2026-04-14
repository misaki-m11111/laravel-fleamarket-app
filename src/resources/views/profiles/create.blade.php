<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h2>プロフィール設定</h2>
  <form method="POST" action="/mypage/profile">
    @csrf
    <label>ユーザー名</label>
    <input name="name">
    <label>郵便番号</label>
    <input name="post_code">
    <label>住所</label>
    <input name="address">
    <label>建物名</label>
    <input name="building">
    <button type="submit">更新する</button>
</form>
</body>
</html>