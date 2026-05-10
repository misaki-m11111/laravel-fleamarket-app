@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/layout/tabs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/component/item-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/component/user-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-profile">
        <div class="mypage-profile__info">
            <div class="mypage-profile__icon">
                <x-user-icon :user="$user" />
            </div>

            <div class="mypage-profile__name">
                <p>{{ $user->name }}</p>
            </div>
        </div>

        <div class="mypage-profile__edit">
            <a href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>

    <div class="tabs mypage-tabs">
        <a href="/mypage?my=sell" class="{{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="/mypage?my=buy" class="{{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <div class="mypage__items-index">
        @if ($items->isEmpty())
            <p>商品はありません</p>
        @else
            <div class="item-list mypage__items-list">
                @foreach ($items as $item)
                    <x-item-card :item="$item" />
                @endforeach
            </div>
        @endif
    @endsection
