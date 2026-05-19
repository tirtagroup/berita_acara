<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_candidate_header extends Model
{
    protected $table = 'tr_candidate';
    protected $primaryKey = 'Ktp';
    protected $keyType = 'string';
    protected $fillable = [
        'Name',
        'Ktp',
        'domisili',
        'CityBirth',
        'Birthdate',
        'status',
        'jenis_kelamin',
        'agama',
        'Handphone',
        'Email',
        'pengajuan_gaji', 
        'Info_lowongan',
        'Position_aplly',
        'others'
    ];

}
