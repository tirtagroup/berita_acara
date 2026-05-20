<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BaKategoriOpsi extends Model
{
    protected $table = 'ms_ba_kategori_opsi';

    protected $fillable = [
        'deskripsi',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Kategori-kategori yang attach ke opsi ini (N:M).
     * Pivot punya kolom: kode, sort_order, active.
     */
    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(
            BaKategori::class,
            'ms_kategori_opsi_mapping',
            'opsi_id',
            'kategori_id'
        )->withPivot('kode', 'sort_order', 'active')->withTimestamps();
    }

    /**
     * Konteks yang attach langsung ke opsi ini (untuk filter di wizard).
     */
    public function konteksList(): BelongsToMany
    {
        return $this->belongsToMany(
            Konteks::class,
            'ms_opsi_konteks_mapping',
            'opsi_id',
            'konteks_id'
        )->withTimestamps();
    }
}
