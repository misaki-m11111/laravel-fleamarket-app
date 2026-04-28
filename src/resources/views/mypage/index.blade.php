<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>
<h2>マイページ</h2>
    <div class="mypage-profile">
        <div class="profile-left">

            <div class="profile-image">
                <img src="{{ asset('storage/' . $profile->image) }}" alt="プロフィール画像" width="100">
            </div>

            <div class="profile-name">
                <h3>{{ $user->name }}</h3>
            </div>
        </div>

        <div class="profile-edit">
            <a href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>

    <div class="mypage-tabs">
        <a href="/mypage?my=sell">出品した商品</a>
        <a href="/mypage?my=buy">購入した商品</a>
    </div>

    @if($items->isEmpty())
        <p>商品はありません</p>
    @else

    @foreach ($items as $item)
    <div class="item">
        <a href="/item/{{$item->id }}">
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="200">
            <p>{{ $item->name }}</p>
            <p>{{ $item->price }}</p>

        @if ($item->sold_at)
            <p style="color:red;">SOLD</p>
        @endif
        </a>
    </div>
    @endforeach
    @endif
</div>
</body>
</html>

