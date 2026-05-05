@extends('layouts.app')

@section('title', '商品購入')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/page/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <form action="/purchase/{{ $item->id }}" method="post" class="purchase__form">
        @csrf

        <input type="hidden" name="item_id" value="{{ $item->id }}">

        <div class="purchase__left">
            <div class="purchase-item">
                <div class="purchase-item__image">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                </div>

                <div class="purchase-item__info">
                    <h2 class="purchase-item__name">{{ $item->name }}</h2>
                    <p class="purchase-item__price">￥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="purchase-section">
                <h3 class="purchase-section__title">支払い方法</h3>

                <select name="payment_method" class="purchase-section__select">
                    <option value="">選択してください</option>
                    <option value="1" {{ old('payment_method') == 1 ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="2" {{ old('payment_method') == 2 ? 'selected' : '' }}>クレジットカード払い</option>
                </select>
            </div>

            <div class="purchase-section">
                <div class="purchase-section__heading">
                    <h3 class="purchase-section__title">配送先</h3>
                    <a href="/purchase/address/{{ $item->id }}" class="purchase-section__link">変更する</a>
                </div>

                <div class="purchase-address">
                    <p>〒 {{ $profile->post_code ?? '' }}</p>
                    <p>
                        {{ $profile->address ?? '' }}
                        {{ $profile->building ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="purchase__right">
            <div class="purchase-summary">
                <div class="purchase-summary__row">
                    <p>商品代金</p>
                    <p>￥{{ number_format($item->price) }}</p>
                </div>

                <div class="purchase-summary__row">
                    <p>支払い方法</p>
                    <p>コンビニ払い</p>
                </div>
            </div>

            <button type="submit" class="purchase__button">購入する</button>
        </div>
    </form>
</div>
@endsection