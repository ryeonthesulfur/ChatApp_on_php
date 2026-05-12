@extends('layouts.app')

@section('body')
<div class="account-page" id="account-page">
    <div class="account-page__inner clearfix">
        <div class="account-page__inner--left account-page__header">
            <h2>Log in</h2>
            <h5>登録しているユーザーでログイン</h5>
            <div style="margin-top: 20px;">
                <a href="{{ route('register') }}" class="btn" style="display: block; margin-bottom: 10px; width: fit-content;">Sign up</a>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="btn" style="display: block; width: fit-content;">Forgot your password?</a>
                @endif
            </div>
        </div>
        <div class="account-page__inner--right user-form">
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
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <div class="field-label">
                        <label for="email">Email</label>
                    </div>
                    <div class="field-input">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus required>
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">
                        <label for="password">Password</label>
                        <i>（英数字6文字以上）</i>
                    </div>
                    <div class="field-input">
                        <input id="password" type="password" name="password" autocomplete="off" required>
                    </div>
                </div>
                <div class="actions">
                    <input type="submit" value="Log in" class="btn">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
