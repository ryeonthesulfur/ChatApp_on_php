<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class MessageController extends Controller
{
    //
    // ルートモデルバインディングにより、URLのIDに一致するRoomインスタンスが自動的に$roomに注入される
    public function index(Room $room)
    {
        return view('messages.index', [
            'room' => $room,
            'messages' => $room->messages()->with('user')->latest()->get()
        ]);
    }


    public function store(Request $request, Room $room)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        // ルームに紐づいたメッセージをcreateの配列内で渡してキーバリュー保存
        $room->messages()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        return redirect()->route('messages.index', $room);
    }
}
