<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail
{
     // マスアサインメント保護の設定（Rails の strong parameters に相当）
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    //ルームとのアソシエーション
    public function rooms()
    {
        // 「自分のキーが先、相手のキーが後」という規則に従って、belongsToManyの引数を指定
        return $this->belongsToMany(Room::class, 'room_users', 'user_id', 'room_id');
    }

    // メッセージとのアソシエーション
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
