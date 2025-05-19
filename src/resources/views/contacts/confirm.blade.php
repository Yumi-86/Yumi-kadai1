@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/confirm.css') }}">
@endsection

@section('content')
<main class="page">
    <div class="container">
        <div class="confirm__content">
            <div class="confirm__heading">
                <h2 class="confirm__heading-text">Confirm</h2>
            </div>

            <div class="form-table">
                <table class="form-table__inner">
                    <tr class="form-table__row">
                        <th class="form-table__header">お名前</th>
                        <td class="form-table__content">{{ $contact['last_name']. '　' . $contact['first_name'] }}</td>
                    </tr>
                    <tr class="form-table__row">
                        <th class="form-table__header">性別</th>
                        <td class="form-table__content">{{ $contact['gender_label'] }}</td>
                    </tr>
                    <tr class="form-table__row">
                        <th class="form-table__header">メールアドレス</th>
                        <td class="form-table__content">{{ $contact['email'] }}</td>
                    </tr>
                    <tr class="form-table__row">
                        <th class="form-table__header">電話番号</th>
                        <td class="form-table__content">{{ $contact['tel1'] }}-{{ $contact['tel2'] }}-{{ $contact['tel3'] }}</td>
                    </tr>
                    <tr class="form-table__row">
                        <th class="form-table__header">住所</th>
                        <td class="form-table__content">{{ $contact['address'] }}</td>
                    </tr>
                    <tr class="form-table__row">
                        <th class="form-table__header">建物名</th>
                        <td class="form-table__content">{{ $contact['building'] }}</td>
                    </tr>
                    <tr class="form-table__row">
                        <th class="form-table__header">お問い合わせの種類</th>
                        <td class="form-table__content">{{ $contact['category_label'] }}</td>
                    </tr>
                    <tr class="form-table__row">
                        <th class="form-table__header">お問い合わせ内容</th>
                        <td class="form-table__content">{{ $contact['detail'] }}</td>
                    </tr>
                </table>
            </div>

            <div class="confirm__button-wrapper">
                <form action="/thanks" method="post" class="confirm__form">
                    @csrf
                    @foreach ($contact as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button class="confirm__button--submit" type="submit">送信</button>
                </form>

                <form action="/" method="post" class="edit__form">
                    @csrf
                    @foreach ($contact as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button class="edit__button--submit" type="submit">修正</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection