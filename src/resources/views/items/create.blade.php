@extends('layouts.app')

@section('title', '商品出品')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page/item/item-create.css') }}">
@endsection

@section('content')

    <div class="sell-form">
        <h1 class="form__title sell-form__title">商品の出品</h1>

        <form class="form sell-form__body" method="POST" action="/sell" enctype="multipart/form-data">
            @csrf

            <div class="form__group">
                <label class="form__label">商品画像</label>

                <div class="sell-form__image-box">
                    <label for="image" class="sell-form__file-button">
                        画像を選択する
                    </label>

                    <input id="image" class="sell-form__file-input" type="file" name="image">
                </div>

                @error('image')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="sell-form__section-title">商品の詳細</h2>

            <div class="form__group">
                <p class="form__label">カテゴリー</p>

                <div class="sell-form__categories">
                    @foreach ($categories as $category)
                        <label class="sell-form__category">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>

                @error('categories')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">商品の状態</label>

                <select class="form__input" name="condition">
                    <option value="">選択してください</option>

                    @foreach ($conditions as $key => $value)
                        <option value="{{ $key }}" {{ old('condition') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

                @error('condition')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="sell-form__section-title">商品名と説明</h2>

            <div class="form__group">
                <label class="form__label">商品名</label>

                <input class="form__input" type="text" name="name" value="{{ old('name') }}">

                @error('name')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">ブランド名</label>

                <input class="form__input" type="text" name="brand_name" value="{{ old('brand_name') }}">

                @error('brand_name')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">商品の説明</label>

                <textarea class="form__input sell-form__textarea" name="description">{{ old('description') }}</textarea>

                @error('description')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">販売価格</label>

                <input class="form__input" type="number" name="price" value="{{ old('price') }}" placeholder="¥">

                @error('price')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <button class="form__button sell-form__button" type="submit">
                出品する
            </button>
        </form>
    </div>

@endsection
