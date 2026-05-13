<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
     // マスアサインメント保護の設定（Rails の strong parameters に相当）
    protected $fillable = ['room_id', 'user_id', 'content', 'image'];
    
    //user とのアソシエーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //room とのアソシエーション
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
