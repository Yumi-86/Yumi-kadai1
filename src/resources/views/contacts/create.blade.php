@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/create.css') }}">
@endsection

@section('content')
<main class="page">
    <div class="container">
        <div class="contact__content">
            <div class="contact__heading">
                <h2 class="contact__heading-text">Contact</h2>
            </div>
            <form action="/confirm" method="post" class="contact-form" novalidate enctype="multipart/form-data">
                @csrf
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">お名前<span class="contact-form__label-item--red">※</span></span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__name">
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="contact-form__name-input" placeholder="例: 山田">
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="contact-form__name-input" placeholder="例: 太郎">
                        </div>
                        @error('last_name')
                        <div class="contact-form__error">{{$message}}</div>
                        @enderror
                        @error('first_name')
                        <div class="contact-form__error">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">性別<span class="contact-form__label-item--red">※</span></span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__gender">
                            <label class="contact-form__gender-radio">
                                <input type="radio" name="gender" value="1" {{ old('gender', '1' ) == '1' ? 'checked' : '' }}> 男性
                            </label>
                            <label class="contact-form__gender-radio">
                                <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}> 女性
                            </label>
                            <label class="contact-form__gender-radio">
                                <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}> その他
                            </label>
                        </div>
                        @error('gender')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">メールアドレス<span class="contact-form__label-item--red">※</span></span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__email">
                            <input type="email" name="email" value="{{ old('email') }}" class="contact-form__email-input" placeholder="text@example.com">
                        </div>
                        @error('email')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">電話番号<span class="contact-form__label-item--red">※</span></span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__tel">
                            <input type="tel" name="tel1" value="{{ old('tel1') }}" class="contact-form__tel-input" maxlength="3" placeholder="080">
                            <span>-</span>
                            <input type="tel" name="tel2" value="{{ old('tel2') }}" class="contact-form__tel-input" maxlength="4" placeholder="1234">
                            <span>-</span>
                            <input type="tel" name="tel3" value="{{ old('tel3') }}" class="contact-form__tel-input" maxlength="4" placeholder="5678">
                        </div>
                        @error('tel1')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                        @error('tel2')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                        @error('tel3')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                        @error('full_tel')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">住所<span class="contact-form__label-item--red">※</span></span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__building">
                            <input type="text" name="address" value="{{ old('address') }}" class="contact-form__address-input" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3">
                        </div>
                        @error('address')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">建物名</span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__building">
                            <input type="text" name="building" value="{{ old('building') }}" class="contact-form__building-input" placeholder="例: 千駄ヶ谷マンション101">
                        </div>
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">お問い合わせの種類<span class="contact-form__label-item--red">※</span></span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__category">
                            <select name="category_id" class="contact-form__category-select">
                                <option value="" disabled selected hidden class="placeholder-option">選択してください</option>
                                @foreach( $categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">お問い合わせ内容<span class="contact-form__label-item--red">※</span></span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__detail">
                            <textarea name="detail" rows="7" placeholder="お問い合わせ内容をご記載ください" class="contact-form__detail-textarea">{{ old('detail') }}</textarea>
                        </div>
                        @error('detail')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">どこで知りましたか？<span class="contact-form__label-item--red">※</span><span class="contact-form__label-item--avalability">複数選択可</span>
                    </div>
                    <div class="contact-form__content">
                        <div class="contact-form__channel">
                            @foreach( $channels as $channel)
                            <label class="contact-form__channel-check">
                                <input type="checkbox" name="channel_id[]" value="{{ $channel->id }}" {{ in_array($channel->id, old('channel_id', [])) ? 'checked' : '' }}>
                                {{ $channel->content}}
                            </label>
                            @endforeach
                        </div>
                        @error('channel_id')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @if (!empty(old('image_path')))
                <div class="image-preview">
                    <p>前回アップロードされた画像:</p>
                    <img src="{{ asset('storage/' . old('image_path')) }}" alt="プレビュー画像" style="max-width: 200px;">
                    <input type="hidden" name="image_path" value="{{ old('image_path') }}">
                    <p>※画像を変更するには再度ファイルを選んでください</p>
                </div>
                @endif
                <div class="contact-form__group">
                    <div class="contact-form__label">
                        <span class="contact-form__label-item">商品画像の添付</span>
                    </div>
                    <div class="contact-form__content">
                        <input type="file" name="image" class="contact-form__file-input" accept="image/*">
                        @error('image')
                        <div class="contact-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="contact-form__button">
                    <button class="contact-form__button-submit" type="submit">確認画面</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection