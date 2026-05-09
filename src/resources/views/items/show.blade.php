@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/component/user-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/component/item-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page/item/item-show.css') }}">
@endsection

@section('content')
    <div class="item-show">
        <div class="item-show__image-area">
            <img class="item-show__image" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
        </div>

        <div class="item-show__content">
            <h1 class="item-show__name">{{ $item->name }}</h1>
            <p class="item-show__brand">{{ $item->brand_name }}</p>
            <p class="item-show__price">￥{{ number_format($item->price) }} <span>(税込)</span></p>

            <div class="item-actions">
                <div class="item-action">
                    <form action="/like/{{ $item->id }}" method="post">
                        @csrf

                        @if ($item->likes->where('user_id', auth()->id())->count())
                            @method('DELETE')
                            <button type="submit" class="item-action__button">
                                <img src="{{ asset('images/heart-pink.png') }}" alt="いいね解除">
                            </button>
                        @else
                            <button type="submit" class="item-action__button">
                                <img src="{{ asset('images/heart-white.png') }}" alt="いいね">
                            </button>
                        @endif
                    </form>

                    <p class="item-action__count">{{ $item->likes->count() }}</p>
                </div>

                <div class="item-action">
                    <a href="#comment-form" class="item-action__button">
                        <img src="{{ asset('images/comment.png') }}" alt="コメント">
                    </a>
                    <p class="item-action__count">{{ $item->comments->count() }}</p>
                </div>
            </div>

            <a href="/purchase/{{ $item->id }}" class="form__button purchase-button">
                購入手続きへ
            </a>

            <section class="item-section">
                <h2>商品説明</h2>
                <p>{{ $item->description }}</p>
            </section>

            <section class="item-section">
                <h2>商品の情報</h2>

                <div class="item-info">
                    <p class="item-info__label">カテゴリー</p>
                    <div class="item-info__content">
                        @foreach ($item->categories as $category)
                            <span class="category-tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="item-info">
                    <p class="item-info__label">商品の状態</p>
                    <p class="item-info__content">{{ $item->condition_label }}</p>
                </div>
            </section>

            <section class="comment-section">
                <h2 class="comment-section__title">コメント({{ $item->comments->count() }})</h2>

                @foreach ($item->comments as $comment)
                    <div class="comment">
                        <div class="comment-user">
                            <x-user-icon :user="$comment->user" />
                            <p>{{ $comment->user->name }}</p>
                        </div>

                        <p class="comment__content">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </section>

            <section class="comment-form-section">
                <h3>商品へのコメント</h3>

                <form id="comment-form" action="/comment/{{ $item->id }}" method="post">
                    @csrf

                    <textarea name="content" class="comment-form__textarea">{{ old('content') }}</textarea>

                    <button type="submit" class="form__button">コメントを送信する</button>
                </form>
            </section>
        </div>
    </div>
@endsection
