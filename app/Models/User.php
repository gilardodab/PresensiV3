<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username', 'email', 'password', 'fullname', 'registered', 'created_login', 'last_login', 'session', 'ip', 'browser', 'level'
    ];
    // public function level_user()
    // {
    //     return $this->hasOne('App\Models\LevelUser', 'level', 'level');
    // }
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'registered' => 'datetime',
        'created_login' => 'datetime',
        'last_login' => 'datetime',
    ];


}
