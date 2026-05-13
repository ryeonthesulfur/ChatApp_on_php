@use('Illuminate\Support\Facades\Storage')
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
                @if($message->image)
                    <img src="{{ Storage::url($message->image) }}" class="message-image">
                @endif
            </div>
        </div>
    @endforeach
</div>

<form method="POST" action="{{ route('messages.store', $room->id) }}" class="formInput" enctype="multipart/form-data">
    @csrf
    <div class="form">
        <input type="text" name="content" class="type-message" placeholder="type a message">
             <span id="file-name" class="file-name"></span>
             <label class="form-image">画像
        <input type="file" name="image" class="hidden" accept="image/*" onchange="document.getElementById('file-name').textContent = this.files[0]?.name ?? ''">
            </label>
           
    </div>
    <input type="submit" value="送信" class="send-button">
</form>

<script>
    const chatView = document.querySelector('.chat-view');
    chatView.scrollTop = chatView.scrollHeight;
</script>

@endsection
