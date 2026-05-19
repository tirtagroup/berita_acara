<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardAllCandidates extends Model
{
    protected $table = 'all_kandidats';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'Name',
        'domisili',
        'Birthdate',
        'umur',
        'jenis_kelamin',
        'agama',
        'Handphone',
        'Position_aplly1',
        'created_at',
        'Perusahaan',
        'Ktp',
        'CekShorlist',
        'PICShortlist',
        'CekCall',
        'CekInterview'
    ];
}
