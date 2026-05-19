<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrBaKategoriD extends Model
{
    protected $table = 'tr_ba_kategori_d';

    protected $fillable = [
        'tr_ba_main_code',
        'kategori_id',
        'opsi_id',
        'created_by',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BaKategori::class, 'kategori_id');
    }

    public function opsi(): BelongsTo
    {
        return $this->belongsTo(BaKategoriOpsi::class, 'opsi_id');
    }

    public function baHeader(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Tr_BA_Main_New::class,
            'tr_ba_main_code',
            'Tr_BA_Main_Code'
        );
    }
}
