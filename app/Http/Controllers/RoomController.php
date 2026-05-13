<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;

class RoomController extends Controller
{
    //
    public function index()
    {
        return view('rooms.index');
    }


    public function create()
    {
        // ユーザー一覧を取得（自分以外）
        $users = User::where('id', '!=', auth()->id())->get();

        // ルーム作成フォームを表示, ユーザー一覧も渡す
        return view('rooms.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $room = Room::create([
            'name' => $request->name
        ]);

        // フォームから受け取ったユーザーIDの空値を除去し、ルーム作成者（自分）のIDを追加してメンバーとして登録する
        $member_ids = array_merge(array_filter($request->user_ids ?? []), [auth()->id()]);
        $room->users()->attach($member_ids);

        return redirect()->route('rooms.index');
    }


    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index');
    }







}
