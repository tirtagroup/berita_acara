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
     * BU yang attach langsung ke opsi ini (untuk filter di wizard).
     */
    public function businessUnits(): BelongsToMany
    {
        return $this->belongsToMany(
            BusinessUnit::class,
            'ms_opsi_bu_mapping',
            'opsi_id',
            'bu_id'
        )->withTimestamps();
    }
}
