<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'candidate_skill';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'Skill',
        'tingkat',
        'siap_tes'
    ];

}
