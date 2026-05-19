<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengalaman3 extends Model
{
    protected $table = 'candidate_pengalaman3';
    // protected $primaryKey = 'Ktp ';
    // protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'Perusahaan3',
        'Posisi3',
        'Lama_kerja3',
        'Gaji3',
        'No_hp3',
        'alasan_keluar3',
        'komentar3'
    ];
}
