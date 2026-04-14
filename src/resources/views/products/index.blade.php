<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<h1>商品一覧</h1>
@foreach ($products as $product)
<a href="/item/{{$product->id }}">
  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"></a>
    <p>{{ $product->name }}</p>
    <p>{{ $product->price }}</p>
@endforeach
</body>
</html>
