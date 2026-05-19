<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengalaman2 extends Model
{
    protected $table = 'candidate_pengalaman2';
    // protected $primaryKey = 'Ktp ';
    // protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'Perusahaan2',
        'Posisi2',
        'Lama_kerja2',
        'Gaji2',
        'No_hp2',
        'alasan_keluar2',
        'komentar2'
    ];
}
