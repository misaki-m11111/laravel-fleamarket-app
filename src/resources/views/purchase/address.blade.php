<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>住所の変更</title>
</head>
<body>
  <h2>住所の変更</h2>
  <form action="/purchase/address/{{ $item->id }}" method="post">
    @csrf

    <label>郵便番号</label>
    <input type="text" name="post_code" value="{{ old('post_code', $profile->post_code ?? '') }}">

    <label>住所</label>
    <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}">

    <label>建物名</label>
    <input type="text" name="building" value="{{ old('building', $profile->building ?? '') }}" >

    <button type="submit">更新する</button>

  </form>
</body>
</html>