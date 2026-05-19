<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Userss extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // protected $table = 'tb_user';
    // protected $primaryKey = 'user_id';
    protected $table ='users';
    protected $primaryKey = 'id';

    protected $fillable = [

        'username',
        'name',
        'email',
        'divisi',
        'password',
    ];
}
