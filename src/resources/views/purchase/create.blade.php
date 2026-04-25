<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品購入</title>
</head>
<body>

  <h2>商品購入</h2>

  <form method="POST" action="">
    @csrf

    <input type="hidden" name="item_id" value="{{ $item->id }}">

    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="300">
    <p>商品名：{{ $item->name }}</p>
    <p>価格：￥{{ number_format($item->price) }}円</p>

    <h3>支払い方法</h3>
    <select name="payment_method">
      <option value="1" {{ old('payment_method') == 1 ? 'selected' : '' }}>コンビニ払い</option>
      <option value="2" {{ old('payment_method') == 2 ? 'selected' : '' }}>クレジットカード払い</option>
    </select>

    <h3>配送先</h3>
    <a href="/purchase/address/{{ $item->id }}">変更する</a>

    <p>〒{{ $profile->post_code ?? '' }}</p>
    <p>{{ $profile->address ?? '' }}</p>
    <p>{{ $profile->building ?? '' }}</p>

    <h3>商品代金</h3>
    <p>{{ number_format($item->price) }}円</p>

    <h3>支払い方法</h3>
    <!-- 仮表示（JSなし） -->
    <p>※選択した支払い方法は購入確定時に反映されます</p>

    <button type="submit">購入する</button>

  </form>

</body>
</html>