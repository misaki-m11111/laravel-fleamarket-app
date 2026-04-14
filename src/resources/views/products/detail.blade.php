<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<h1>商品詳細</h1>
  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
  <p>{{ $product->name }}</p>
  <p>{{ $product->price }}</p>
  <p>{{ $product->description }}</p>
</body>
</html>