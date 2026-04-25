<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品出品</title>
</head>
<body>
    <h2>商品の出品</h2>

    <form method="POST" action="/sell" enctype="multipart/form-data">
        @csrf

        <h3>商品画像</h3>
        <input type="file" name="image">

        <h3>商品の詳細</h3>

        <h4>カテゴリー</h4>
        @foreach ($categories as $category)
            <label>
                <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                {{ $category->name }}
            </label>
        @endforeach

        <h4>商品の状態</h4>
        <select name="condition">
            <option value="">選択してください</option>
            @foreach ($conditions as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <h3>商品名と説明</h3>

        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name') }}">

        <label>ブランド名</label>
        <input type="text" name="brand_name" value="{{ old('brand_name') }}">

        <label>商品の説明</label>
        <textarea name="description">{{ old('description') }}</textarea>

        <label>販売価格</label>
        <input type="number" name="price" value="{{ old('price') }}">

        <button type="submit">出品する</button>
    </form>
</body>
</html>