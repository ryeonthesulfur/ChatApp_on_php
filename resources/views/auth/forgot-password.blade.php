@extends('layouts.app')

@section('body')
<div class="account-page" id="account-page">
    <div class="account-page__inner clearfix">
        <div class="account-page__inner--left account-page__header">
            <h2>Forgot Password</h2>
            <h5>パスワードの再設定</h5>
        </div>
        <div class="account-page__inner--right user-form">
            @if(session('status'))
                <div id="error_explanation">
                    <p>{{ session('status') }}</p>
                </div>
            @endif
            @if($errors->any())
                <div id="error_explanation">
                    <h2>{{ $errors->count() }}つのエラーが見つかりました</h2>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <p>登録したメールアドレスにパスワード再設定のリンクを送信します。</p>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="field">
                    <div class="field-label">
                        <label for="email">Email</label>
                    </div>
                    <div class="field-input">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus required>
                    </div>
                </div>
                <div class="actions">
                    <input type="submit" value="送信する" class="btn">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
