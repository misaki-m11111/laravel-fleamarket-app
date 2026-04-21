<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品詳細</title>
</head>
<body>
  <h2>商品詳細</h2>
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="500">
    <p>{{ $product->name }}</p>
    <p>{{ $product->price }}</p>
    <p>{{ $product->description }}</p>
</body>
</html>