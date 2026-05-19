<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'userlogin';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id ',
        'Username',
        'Password'
    ];
}
