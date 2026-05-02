@extends('layouts.app')

@section('title', '住所の変更')

@section('content')
<div class="form">
    <h1 class="form__title">住所の変更</h1>

    <form action="/purchase/address/{{ $item->id }}" method="POST" class="form__form">
        @csrf

        <div class="form__group">
            <label class="form__label">郵便番号</label>
            <input
                type="text"
                name="post_code"
                value="{{ old('post_code', $profile->post_code ?? '') }}"
                class="form__input"
            >
            @error('post_code')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="form__label">住所</label>
            <input
                type="text"
                name="address"
                value="{{ old('address', $profile->address ?? '') }}"
                class="form__input"
            >
            @error('address')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="form__label">建物名</label>
            <input
                type="text"
                name="building"
                value="{{ old('building', $profile->building ?? '') }}"
                class="form__input"
            >
            @error('building')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="form__button">更新する</button>
    </form>
</div>
@endsection