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
            <form action="/thanks" method="post" class="confirm-form">
                @csrf
                <div class="form-table">
                    <table class="form-table__inner">
                        <tr class="form-table__row">
                            <th class="form-table__header">お名前</th>
                            <td class="form-table__content">
                                <input type="text" name="full_name" value="{{ $contact->full_name }}" readonly>
                                <input type="hidden" name="first_name" value="{{ $contact->first_name }}">
                                <input type="hidden" name="last_name" value="{{ $contact->last_name }}">
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">性別</th>
                            <td class="form-table__content">
                                <input type="text" value="{{ $contact->gender_label }}" name="gender_label" disabled>
                                <input type="hidden" name="gender" value="{{ $contact->gender }}">
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">メールアドレス</th>
                            <td class="form-table__content">
                                <input type="email" name="email" value="{{ $contact->email }}" readonly>
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">電話番号</th>
                            <td class="form-table__content">
                                <input type="tel" name="full_tel" value="{{ $contact->full_tel }}" readonly>
                                <input type="hidden" name="tel1" value="{{ $contact->tel1 }}">
                                <input type="hidden" name="tel2" value="{{ $contact->tel2 }}">
                                <input type="hidden" name="tel3" value="{{ $contact->tel3 }}">
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">住所</th>
                            <td class="form-table__content">
                                <input type="text" name="address" value="{{ $contact->address }}" readonly>
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">建物名</th>
                            <td class="form-table__content">
                                <input type="text" name="building" value="{{ $contact->building }}" readonly>
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">お問い合わせの種類</th>
                            <td class="form-table__content">
                                <input type="text" name="category" value="{{ $contact->category->content }}" readonly>
                                <input type="hidden" name="category_id" value="{{ $contact->category_id }}">
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">お問い合わせ内容</th>
                            <td class="form-table__content">
                                <input type="text" name="detail" value="{{ $contact->detail }}" readonly>
                            </td>
                        </tr>
                        <tr class="form-table__row">
                            <th class="form-table__header">どこで知りましたか？</th>
                            <td class="form-table__content">
                                <input type="text" value="{{ implode(' 、 ' , $channel_labels) }}" disabled>
                                @foreach( $channel_ids as $id)
                                <input type="hidden" name="channel_id[]" value="{{ $id }}">
                                @endforeach
                            </td>
                        </tr>
                        @if (!empty($contact->image_path))
                        <tr class=" form-table__row">
                            <th class="form-table__header">添付画像</th>
                            <td class="form-table__content">
                                <img src="{{ asset('storage/' . $contact->image_path) }}" alt="添付画像" style="max-width: 200px;">
                                <input type="hidden" name="image_path" value="{{ $contact->image_path }}">
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="confirm__button-wrapper button-pair">
                    <button class="confirm__button--submit" type="submit">送信</button>
                </div>
            </form>
            <form action="/" method="post" class="edit-form" novalidate>
                @csrf
                <div class="edit__button-wrapper button-pair">
                    @foreach( $contact->toArray() as $key => $value)
                    @if (!is_array($value))
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                    @endforeach
                    @foreach( $channel_ids as $id)
                    <input type="hidden" name="channel_id[]" value="{{ $id }}">
                    @endforeach
                    <button class="edit__button--submit" type="submit">修正</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection