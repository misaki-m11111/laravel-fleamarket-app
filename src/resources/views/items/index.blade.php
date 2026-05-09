@extends('layouts.app')

@section('title','商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/layout/tabs.css') }}">
<link rel="stylesheet" href="{{ asset('css/component/item-card.css') }}">
<link rel="stylesheet" href="{{ asset('css/page/item/item-index.css') }}">
@endsection

@section('content')
<div class="tabs item-tabs">
    <a href="/?tab=recommend" class="tabs__link {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
    <a href="/?tab=mylist" class="tabs__link {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

<div class="items-index">
    @if($items->isEmpty())
        <p>商品はありません</p>
    @else
        <div class="item-list items-index__list">
            @foreach ($items as $item)
                <x-item-card :item="$item" />
            @endforeach
        </div>
    @endif
</div>
@endsection