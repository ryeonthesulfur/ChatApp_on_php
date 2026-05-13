@extends('layouts.app')

@section('body')
<div class="chat-room-form">
    <h1>新規チャットルーム</h1>

    @if($errors->any())
        <div class="chat-room-form__errors">
            <h2>{{ $errors->count() }}つのエラーが見つかりました</h2>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('rooms.store') }}">
        @csrf

        <div class="chat-room-form__field">
            <div class="chat-room-form__field--left">
                <label class="chat-room-form__label" for="name">チャットルーム名</label>
            </div>
            <div class="chat-room-form__field--right">
                <input type="text" id="name" name="name" class="chat-room-form__input" placeholder="チャットルーム名を入力してください" value="{{ old('name') }}">
            </div>
        </div>

        <div class="chat-room-form__field">
            <div class="chat-room-form__field--left">
                <label class="chat-room-form__label">チャットメンバー</label>
            </div>
            <div class="chat-room-form__field--right">
                <select name="user_ids[]">
                    <option value="">チャットするユーザーを選択してください</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="chat-room-form__field">
            <div class="chat-room-form__field--left"></div>
            <div class="chat-room-form__field--right">
                <input type="submit" value="作成する" class="chat-room-form__action-btn">
            </div>
        </div>

    </form>
</div>
@endsection
