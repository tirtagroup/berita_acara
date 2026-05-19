<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Pivot model untuk N:M antara BaKategori dan BaKategoriOpsi.
 * Punya kolom kategori-spesifik: kode, sort_order, active.
 */
class KategoriOpsiMapping extends Model
{
    protected $table = 'ms_kategori_opsi_mapping';

    protected $fillable = [
        'kategori_id',
        'opsi_id',
        'kode',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BaKategori::class, 'kategori_id');
    }

    public function opsi(): BelongsTo
    {
        return $this->belongsTo(BaKategoriOpsi::class, 'opsi_id');
    }
}
