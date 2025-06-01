@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/index.css') }}">
@endsection

@section('nav')
<form action="/logout" method="post" class="logout-form">
    @csrf
    <button class="header-nav__button">logout</button>
</form>
@endsection
@section('content')
<main class="page">
    <div class="container">
        <div class="admin">
            <div class="admin__heading">
                <h2 class="admin__heading-text">
                    admin
                </h2>
            </div>

            <form action="/admin" method="post" class="search-form">
                @csrf
                <div class="search-form__content">
                    <div class="search-form__field">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="search-form__input search-form__input--text" placeholder="名前やメールアドレスを入力してください">
                    </div>
                    <div class="search-form__field">
                        <select name="gender" class="search-form__select">
                            <option disabled hidden {{ request('gender')? '': 'selected' }}>性別</option>
                            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                        </select>
                    </div>
                    <div class="search-form__field">
                        <select name="category_id" class="search-form__select">
                            <option hidden disabled {{ request('category_id') ? '': 'selected' }}>お問い合わせの種類</option>
                            @foreach( $categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-form__field">
                        <input type="date" name="date" value="{{ request('date') }}" class="search-form__input search-form__input--date">
                    </div>
                </div>
                <div class="search-form__buttons">
                    <button class="search-form__button search-form__button--submit" type="submit">検索</button>
                    <button class="search-form__button search-form__button--reset">
                        <a href="/admin" class="search-form__button--reset-btn">リセット</a>
                    </button>
                </div>
            </form>
            <div class="function-items">
                <form method="GET" action="/admin/export">
                    @csrf
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                    <input type="hidden" name="gender" value="{{ request('gender') }}">
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    <input type="hidden" name="date" value="{{ request('date') }}">
                    <button type="submit" class="btn btn-primary function-item__export">エクスポート</button>
                </form>

                <div class="function-item__pagination">
                    {{ $contacts->links('vendor.pagination.custom') }}
                </div>
            </div>

            <div class=" admin__table">
                <table class="admin__table-inner">
                    <tr class="admin__table-row">
                        <th class="admin__table-header">お名前</th>
                        <th class="admin__table-header">性別</th>
                        <th class="admin__table-header">メールアドレス</th>
                        <th class="admin__table-header">お問い合わせの種類</th>
                        <th class="admin__table-header"></th>
                    </tr>
                    @foreach( $contacts as $contact)
                    <tr class="admin__table-row">
                        <td class="admin__table-content">{{ $contact->full_name }}</td>
                        <td class="admin__table-content">{{ $contact->gender_label }}</td>
                        <td class="admin__table-content">{{ $contact->email }}</td>
                        <td class="admin__table-content">{{ $contact->category->content }}</td>
                        <td class="admin__table-content">
                            <button type="button" class="btn btn-info btn-sm admin__table-button" data-toggle="modal" data-target="#modal-{{ $contact->id }}">詳細</button>
                            <div class="modal fade" id="modal-{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $contact->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="justify-content: end">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal__content">
                                                <div class="modal__ttl">
                                                    お名前
                                                </div>
                                                <div class="modal__dtl">{{ $contact->full_name }}</div>
                                            </div>
                                            <div class="modal__content">
                                                <div class="modal__ttl">性別
                                                </div>
                                                <div class="modal__dtl">
                                                    {{ $contact->gender_label }}
                                                </div>
                                            </div>
                                            <div class="modal__content">
                                                <div class="modal__ttl">メールアドレス
                                                </div>
                                                <div class="modal__dtl">{{ $contact->email }}
                                                </div>
                                            </div>
                                            <div class="modal__content">
                                                <div class="modal__ttl">電話番号
                                                </div>
                                                <div class="modal__dtl">{{ $contact->tel }}
                                                </div>
                                            </div>
                                            <div class="modal__content">
                                                <div class="modal__ttl">住所
                                                </div>
                                                <div class="modal__dtl">{{ $contact->address }}
                                                </div>
                                            </div>
                                            <div class="modal__content">
                                                <div class="modal__ttl">建物名
                                                </div>
                                                <div class="modal__dtl">{{ $contact->building }}
                                                </div>
                                            </div>
                                            <div class="modal__content">
                                                <div class="modal__ttl">お問い合わせの種類
                                                </div>
                                                <div class="modal__dtl">{{ $contact->category->content }}
                                                </div>
                                            </div>
                                            <div class="modal__content">
                                                <div class="modal__ttl">お問い合わせ内容
                                                </div>
                                                <div class="modal__dtl">{{ $contact->detail }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST" action=/admin>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">削除</button>
                                                <input type="hidden" name="id" value="{{ $contact->id }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>                                   
@endsection