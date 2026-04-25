<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品詳細</title>
</head>
<body>
<img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="200">

<p>{{ $item->name }}</p>
<p>{{ $item->brand_name }}</p>
<p>{{ number_format($item->price) }}円(税込み)</p>

<a href="/purchase/{{ $item->id }}">購入の手続きへ</a>

<h2>商品説明</h2>
<p>{{ $item->description }}</p>

<p>カテゴリー:
  @foreach($item->categories as $category)
    <span>{{ $category->name }}</span>
  @endforeach
</p>

<p>商品の状態: {{ $item->condition_label }}</p>
</body>
</html>