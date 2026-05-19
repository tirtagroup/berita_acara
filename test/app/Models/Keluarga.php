<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'candidate_keluarga';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id ',
        'Ktp',
        'hubungan',
        'namanya',
        'pendidikan',
        'pekerjaan',
        'tempat'
    ];
}
