<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品一覧</title>
</head>
<body>
<h2>商品一覧</h2>
  @foreach ($items as $item)
    <a href="/item/{{$item->id }}">
    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="500"></a>
    <p>{{ $item->name }}</p>
    <p>{{ $item->price }}</p>
  @endforeach
</body>
</html>
