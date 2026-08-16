@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
    <div class="form">
        <h1 class="form__title">ログイン</h1>

        <form method="POST" action="/login" class="form__form">
            @csrf

            <div class="form__group">
                <label class="form__label">メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form__input">
                @error('email')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">パスワード</label>
                <input type="password" name="password" class="form__input">
                @error('password')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="form__button">ログイン</button>
        </form>

        <p class="form__link">
            <a href="/register">会員登録はこちら</a>
        </p>

        <div class="demo-account">
            <p class="demo-account__title">デモアカウント</p>

            <p>購入者</p>
            <p>メールアドレス：buyer@example.com</p>
            <p>パスワード：password1234</p>

            <br>

            <p>出品者</p>
            <p>メールアドレス：seller@example.com</p>
            <p>パスワード：password1234</p>
        </div>
    </div>
@endsection
