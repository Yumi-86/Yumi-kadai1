@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
@endsection

@section('nav')
<ul>
    <li>
        <a href="/register" class="header__nav-register">register</a>
    </li>
</ul>
@endsection

@section('content')

<main class="page">
    <div class="container">
        <div class="login">
            <div class="login__heading">
                <h2 class="login__heading-text">login</h2>
            </div>
        </div>

        <form action="/login" method="POST" class="login__form">
            @csrf

            @error('login')
            <div class="login__error">{{ $message }}</div>
            @enderror

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
                <button type="submit" class="form__button-submit">ログイン</button>
            </div>
        </form>
    </div>
    </div>
</main>
@endsection