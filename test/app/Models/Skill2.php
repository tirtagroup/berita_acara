<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill2 extends Model
{
    protected $table = 'candidate_skill2';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'Skill2',
        'tingkat2',
        'siap_tes2'
    ];

}
