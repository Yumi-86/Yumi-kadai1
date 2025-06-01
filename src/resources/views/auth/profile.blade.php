@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/profile.css') }}">
@endsection

@section('nav')
<ul>
    <li>
        <a href="/login" class="header__nav-login">login</a>
    </li>
</ul>
@endsection

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/profile.css') }}">
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
        <div class="profile">
            <div class="profile__heading">
                <h2 class="profile__heading-text">profile</h2>
            </div>

            <form action="/profile" method="POST" class="profile__form form" novalidate enctype="multipart/form-data">
                @csrf
                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">性別<span class="form__label-text--red">*</span></span>
                    </div>
                    <div class="form__content">
                        <div class="form__gender">
                            <label class="form__gender-radio">
                                <input type="radio" name="gender" value="1" {{ old('gender', '1' ) == '1' ? 'checked' : '' }}> 男性
                            </label>
                            <label class="form__gender-radio">
                                <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}> 女性
                            </label>
                            <label class="form__gender-radio">
                                <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}> その他
                            </label>
                        </div>
                        @error('gender')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">誕生日<span class="form__label-text--red">*</span></span>
                    </div>
                    <div class="form__content">
                        <input type="date" name="birthday" value="{{ old('birthday') }}" class="form__birthday">
                        @error('birthday')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">電話番号</span>
                    </div>
                    <div class="form__content">
                        <input type="tel" name="tel" placeholder="08012345678" value="{{ old('tel') }}" class="form__tel">
                        @error('tel')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">住所（都道府県）</span>
                    </div>
                    <div class="form__content">
                        <input type="text" name="address" placeholder="東京都" value="{{ old('address') }}" class="form__address">
                        @error('address')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @if (!empty(old('image_path')))
                <div class="image-preview">
                    <p>アップロードされた画像:</p>
                    <img src="{{ asset('storage/' . old('image_path')) }}" alt="プレビュー画像" style="max-width: 200px;">
                    <input type="hidden" name="image_path" value="{{ old('image_path') }}">
                    <p>※画像を変更するには再度ファイルを選んでください</p>
                </div>
                @endif
                <div class="form__group">
                    <div class="form__label">
                        <span class="form__label-text">プロフィール画像</span>
                    </div>
                    <div class="form__content">
                        <input type="file" name="image" class="form__file-input" accept="image/*">
                        @error('image')
                        <div class="contact-form__error">{{ $message }}</div>
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