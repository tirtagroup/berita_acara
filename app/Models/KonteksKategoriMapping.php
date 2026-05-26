<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Pivot Konteks ↔ Kategori (sebelumnya BuKategoriMapping → ms_bu_kategori_mapping).
 * Rename di migration 2026_05_20_180000.
 */
class KonteksKategoriMapping extends Model
{
    protected $table = 'ms_konteks_kategori_mapping';

    protected $fillable = [
        'konteks_id',
        'kategori_id',
    ];

    public function konteks(): BelongsTo
    {
        return $this->belongsTo(Konteks::class, 'konteks_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BaKategori::class, 'kategori_id');
    }
}
