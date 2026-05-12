@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/component/user-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page/profile.css') }}">
@endsection

@section('content')
    <div class="form profile">
        <h1 class="form__title">プロフィール設定</h1>

        <form action="/mypage/profile" method="PUT" enctype="multipart/form-data" class="form__form">
            @csrf

            <div class="profile__image-area">
                <x-user-icon :user="$user" />

                <label class="profile__image-button">
                    画像を選択する
                    <input type="file" name="image" class="profile__image-input">
                </label>
            </div>

            @error('image')
                <p class="form__error">{{ $message }}</p>
            @enderror

            <div class="form__group">
                <label class="form__label">ユーザー名</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form__input">

                @error('name')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">郵便番号</label>
                <input type="text" name="post_code" value="{{ old('post_code', $profile->post_code ?? '') }}"
                    class="form__input">

                @error('post_code')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">住所</label>
                <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}"
                    class="form__input">

                @error('address')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">建物名</label>
                <input type="text" name="building" value="{{ old('building', $profile->building ?? '') }}"
                    class="form__input">

                @error('building')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="form__button">
                {{ $profile ? '更新する' : '登録する' }}
            </button>
        </form>
    </div>
@endsection
