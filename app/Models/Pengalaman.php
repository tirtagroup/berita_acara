<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengalaman extends Model
{
    protected $table = 'candidate_pengalaman';
    // protected $primaryKey = 'Ktp ';
    // protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'Perusahaan',
        'Posisi',
        'Lama_kerja',
        'Gaji',
        'No_hp',
        'alasan_keluar',
        'komentar'
    ];
}
