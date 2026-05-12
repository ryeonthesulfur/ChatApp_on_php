<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Room extends Model
{
    // マスアサインメント保護の設定（Rails の strong parameters に相当）
    protected $fillable = ['name'];

    //messages とのアソシエーション
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    //users とのアソシエーション
    public function users()
    {
        return $this->belongsToMany(User::class, 'room_users', 'room_id', 'user_id');
    }
}
