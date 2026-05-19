<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'candidate_pendidikanya';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'ktp',
        'sekolah',
        'tahunmasuk',
        'tahunlulus',
        'alamat',
        'ipk'

    ];
}
