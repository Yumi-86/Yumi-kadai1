@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/thanks.css') }}">
@endsection

@section('content')
<main class="thanks-page">
    <div class="thanks-page__background-text">Thank you</div>
    <div class="thanks-page__content">
        <p class="thanks-page__message">お問い合わせありがとうございました</p>
        <a href="/" class="thanks-page__button">HOME</a>
    </div>
</main>
@endsection