<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PicaKategori extends Model
{
    protected $table = 'ms_pica_kategori';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
