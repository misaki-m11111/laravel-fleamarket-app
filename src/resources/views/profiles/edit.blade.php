<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール設定</title>
</head>
<body>
  <h2>プロフィール設定</h2>
  <form method="POST" action="/mypage/profile" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" >
      @if ($profile && $profile->image)
      <img src="{{ asset('storage/' . $profile->image) }}" width="100">
      @endif

    <label>ユーザー名</label>
    <input type="text" name="name" value="{{ old('name',$profile->name ?? '') }}">

    <label>郵便番号</label>
    <input type="text" name="post_code" value="{{ old('post_code',$profile->post_code ?? '') }}">

    <label>住所</label>
    <input type="text" name="address" value="{{ old('address',$profile->address ?? '') }}">

    <label>建物名</label>
    <input type="text" name="building" value="{{ old('building',$profile->building ?? '') }}">

  @if ($profile)
    <button>更新する</button>
  @else
    <button>登録する</button>
  @endif
</form>
</body>
</html>