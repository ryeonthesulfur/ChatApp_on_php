@extends('layouts.chat')

@section('main')
<div class="main-header">
    <div class="room-name">{{ $room->name }}</div>
    <div class="quit-chat-button">
        <a href="{{ route('rooms.index') }}">チャットを終了する</a>
    </div>
</div>

<div class="chat-view">
    @foreach($messages as $message)
        <div class="name-time-and-message">
            <div class="name-and-time">
                <div class="user-name">{{ $message->user->name }}</div>
                <div class="time">{{ $message->created_at->format('Y/m/d H:i') }}</div>
            </div>
            <div class="message-and-image">
                <div class="message">{{ $message->content }}</div>
            </div>
        </div>
    @endforeach
</div>

<form method="POST" action="{{ route('messages.store', $room->id) }}" class="formInput">
    @csrf
    <div class="form">
        <input type="text" name="content" class="type-message" placeholder="type a message">
    </div>
    <input type="submit" value="送信" class="send-button">
</form>
@endsection
