<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga2 extends Model
{
    protected $table = 'candidate_keluarga2';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id ',
        'Ktp',
        'hubungan2',
        'namanya2',
        'pendidikan2',
        'pekerjaan2',
        'tempat2'
    ];
}
