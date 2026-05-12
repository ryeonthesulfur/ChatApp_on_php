@extends('layouts.app')

@section('body')
<div class="account-page" id="account-page">
    <div class="account-page__inner clearfix">
        <div class="account-page__inner--left account-page__header">
            <h2>Verify Email</h2>
            <h5>メールアドレスの認証</h5>
        </div>
        <div class="account-page__inner--right user-form">
            @if(session('status') == 'verification-link-sent')
                <div id="error_explanation" style="border-color: #38aef0;">
                    <p style="color: #38aef0;">認証メールを送信しました。</p>
                </div>
            @endif
            <p>登録したメールアドレスに認証リンクを送信しました。メールのリンクをクリックして認証を完了してください。</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="actions">
                    <input type="submit" value="認証メールを再送する" class="btn">
                </div>
            </form>
            <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
                @csrf
                <input type="submit" value="Log Out" class="btn" style="background-color: #ccc;">
            </form>
        </div>
    </div>
</div>
@endsection
