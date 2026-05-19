<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'candidate_sosmed';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'sosmed',
        'nickname'
    ];
}
