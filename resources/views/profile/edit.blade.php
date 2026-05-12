@extends('layouts.app')

@section('body')
<div class="account-page" id="account-page">
    <div class="account-page__inner clearfix" style="display: block; width: 800px;">
        <h2>Profile</h2>

        {{-- Profile Information --}}
        <section>
            <h3>Profile Information</h3>
            <p>名前とメールアドレスの変更</p>
            @if($errors->has('name') || $errors->has('email'))
                <div id="error_explanation">
                    <h2>{{ $errors->count() }}つのエラーが見つかりました</h2>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('status') === 'profile-updated')
                <div id="error_explanation" style="border-color: #38aef0;">
                    <p style="color: #38aef0;">保存しました。</p>
                </div>
            @endif
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                <div class="field">
                    <div class="field-label">
                        <label for="name">Name</label>
                    </div>
                    <div class="field-input">
                        <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" autofocus autocomplete="name" required>
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">
                        <label for="email">Email</label>
                    </div>
                    <div class="field-input">
                        <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" autocomplete="username" required>
                    </div>
                </div>
                @if($mustVerifyEmail && Auth::user()->email_verified_at === null)
                    <div class="field">
                        <p>メールアドレスが未認証です。
                            <form method="POST" action="{{ route('verification.send') }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:none; border:none; color: #38aef0; cursor:pointer; padding:0;">再送する</button>
                            </form>
                        </p>
                        @if(session('status') === 'verification-link-sent')
                            <p style="color: #38aef0;">認証メールを送信しました。</p>
                        @endif
                    </div>
                @endif
                <div class="actions">
                    <input type="submit" value="Save" class="btn">
                </div>
            </form>
        </section>

        <hr style="margin: 80px 0 10px 0;">

        {{-- Update Password --}}
        <section>
            <h3>Update Password</h3>
            <p>パスワードの変更</p>
            @if($errors->has('current_password') || $errors->has('password'))
                <div id="error_explanation">
                    <h2>{{ $errors->count() }}つのエラーが見つかりました</h2>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('status') === 'password-updated')
                <div id="error_explanation" style="border-color: #38aef0;">
                    <p style="color: #38aef0;">保存しました。</p>
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')
                <div class="field">
                    <div class="field-label">
                        <label for="current_password">Current Password</label>
                    </div>
                    <div class="field-input">
                        <input id="current_password" type="password" name="current_password" autocomplete="current-password">
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">
                        <label for="password">New Password</label>
                        <i>（英数字6文字以上）</i>
                    </div>
                    <div class="field-input">
                        <input id="password" type="password" name="password" autocomplete="new-password">
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">
                        <label for="password_confirmation">Confirm Password</label>
                    </div>
                    <div class="field-input">
                        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>
                <div class="actions">
                    <input type="submit" value="Save" class="btn">
                </div>
            </form>
        </section>

        <hr style="margin: 80px 0 10px 0;">

        {{-- Delete Account --}}
        <section>
            <h3>Delete Account</h3>
            <p>アカウントを削除すると、すべてのデータが完全に削除されます。</p>
            <div class="actions">
                <button onclick="document.getElementById('deleteModal').style.display='flex'" class="btn" style="background-color: #d65f4c; color: #fff; cursor: pointer;">
                    Delete Account
                </button>
            </div>
        </section>
    </div>
</div>

<div id="deleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:1000;">
    <div style="background:#fff; padding:40px; border-radius:5px; width:500px;">
        <h3>本当にアカウントを削除しますか？</h3>
        <p>削除を確認するためにパスワードを入力してください。</p>
        @if($errors->has('password'))
            <div id="error_explanation">
                <ul><li>{{ $errors->first('password') }}</li></ul>
            </div>
        @endif
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="field">
                <div class="field-input">
                    <input type="password" name="password" placeholder="Password" autofocus>
                </div>
            </div>
            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="button" onclick="document.getElementById('deleteModal').style.display='none'" class="btn" style="background-color:#ccc; color:#fff; cursor:pointer;">Cancel</button>
                <input type="submit" value="Delete Account" class="btn" style="background-color:#d65f4c; color:#fff;">
            </div>
        </form>
    </div>
</div>
@endsection
