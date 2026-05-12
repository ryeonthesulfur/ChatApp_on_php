@extends('layouts.app')

@section('body')
<div class="account-page" id="account-page">
    <div class="account-page__inner clearfix">
        <div class="account-page__inner--left account-page__header">
            <h2>Reset Password</h2>
            <h5>パスワードの再設定</h5>
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
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="field">
                    <div class="field-label">
                        <label for="email">Email</label>
                    </div>
                    <div class="field-input">
                        <input id="email" type="email" name="email" value="{{ old('email', $email) }}" autocomplete="username" required>
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">
                        <label for="password">新しいPassword</label>
                        <i>（英数字6文字以上）</i>
                    </div>
                    <div class="field-input">
                        <input id="password" type="password" name="password" autofocus autocomplete="new-password" required>
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">
                        <label for="password_confirmation">Password Confirmation</label>
                    </div>
                    <div class="field-input">
                        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                    </div>
                </div>
                <div class="actions">
                    <input type="submit" value="Reset Password" class="btn">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
