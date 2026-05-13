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
            'room' => $room, // ここで$roomをそのまま使える
            'messages' => $room->messages()->with('user')->latest()->get()
            // 「with('user')」でメッセージに関連するユーザー情報も取得(N+1問題対策)、「latest()」で新しい順に並べ替え、最後に「get()」でクエリを実行して結果を取得
        ]);
    }

}
