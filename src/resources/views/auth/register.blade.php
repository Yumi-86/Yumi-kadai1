@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/register.css') }}">
@endsection

@section('nav')
<ul>
    <li>
        <a href="/login" class="header__nav-login">login</a>
    </li>
</ul>
@endsection

@section('content')
<main class="page">
    <div class="container">
        <div class="register">
            <div class="register__heading">
                <h2 class="register__heading-text">register</h2>
            </div>

            <form action="/register" method="POST" class="register__form">
                @csrf
                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">名前</span>
                    </div>
                    <div class="form__content">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="例: テスト太郎" class="form__content-input">
                        @error('name')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">メールアドレス</span>
                    </div>
                    <div class="form__content">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="例: text@example.com" class="form__content-input">
                        @error('email')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">パスワード</span>
                    </div>
                    <div class="form__content">
                        <input type="password" name="password" placeholder="例: coachtech1106" class="form__content-input">
                        @error('password')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__button">
                    <button type="submit" class="form__button-submit">登録</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection