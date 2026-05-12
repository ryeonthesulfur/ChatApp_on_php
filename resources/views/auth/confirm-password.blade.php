@extends('layouts.app')

@section('body')
<div class="account-page" id="account-page">
    <div class="account-page__inner clearfix">
        <div class="account-page__inner--left account-page__header">
            <h2>Confirm Password</h2>
            <h5>パスワードの確認</h5>
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
            <p>続行するにはパスワードを確認してください。</p>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="field">
                    <div class="field-label">
                        <label for="password">Password</label>
                    </div>
                    <div class="field-input">
                        <input id="password" type="password" name="password" autofocus autocomplete="current-password" required>
                    </div>
                </div>
                <div class="actions">
                    <input type="submit" value="確認する" class="btn">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
