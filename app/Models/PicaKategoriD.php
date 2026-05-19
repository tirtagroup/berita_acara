<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicaKategoriD extends Model
{
    protected $table = 'tr_pica_kategori_d';

    protected $fillable = [
        'tr_pica_main_code',
        'kategori_id',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(PicaKategori::class, 'kategori_id');
    }
}
