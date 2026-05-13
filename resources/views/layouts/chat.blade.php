@extends('layouts.app')

@section('body')
<div class="wrapper">
    <div class="side-bar">
        <div class="side-header">
            <div class="user-name-button">
                <a href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a>
            </div>
            <div class="new-chat-button">
                <a href="{{ route('rooms.create') }}">チャットを作成する</a>
            </div>
        </div>
        <div class="rooms">
            @foreach(Auth::user()->rooms as $room)
                <div class="room">
                    <div class="room-name">
                        <a href="{{ route('messages.index', $room->id) }}">{{ $room->name }}</a>
                        <div class="room-menu">
                            <button class="room-menu-btn" onclick="toggleMenu({{ $room->id }})">⋮</button>
                            <div class="room-menu-dropdown" id="menu-{{ $room->id }}" style="display:none;">
                                <form method="POST" action="{{ route('rooms.destroy', $room->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">ルームを削除する</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="logout-button">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
        </div>
    </div>
    <div class="main-chat">
        @yield('main')
    </div>
</div>
@endsection
