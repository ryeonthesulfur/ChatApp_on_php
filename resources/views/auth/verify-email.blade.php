@extends('layouts.app')

@section('body')
<div class="account-page" id="account-page">
    <div class="account-page__inner clearfix">
        <div class="account-page__inner--left account-page__header">
            <h2>Verify Email</h2>
            <h5>先に済ませましょう。</h5>
        </div>
        <div class="account-page__inner--right user-form">
            @if(session('status') == 'verification-link-sent')
                <div id="error_explanation" style="border-color: #38aef0; padding: 0 20px; border-radius: 10px;">
                    <p style="color: #38aef0;">認証メールを送信しました。<br> Mailpitで確認してください。</p>
                </div>
            @endif
            <p>登録したメールアドレスに認証リンクを送信しました。<br>
            メールのリンクをクリックして認証を完了してください。</p>
            <div style="display: flex; gap: 80px; align-items: center; margin-top: 30px;">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <input type="submit" value="認証メールを再送する" class="btn">
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" value="Log Out" class="btn" style="background-color: #8c3131;">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
