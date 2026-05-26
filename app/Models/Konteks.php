<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Konteks — dimensi domain untuk BA/PICA (sebelumnya "Business Unit" / "BU").
 * Table rename: ms_business_unit → ms_konteks di migration 2026_05_20_180000.
 */
class Konteks extends Model
{
    protected $table = 'ms_konteks';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function mappings(): HasMany
    {
        return $this->hasMany(KonteksKategoriMapping::class, 'konteks_id');
    }

    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(
            BaKategori::class,
            'ms_konteks_kategori_mapping',
            'konteks_id',
            'kategori_id'
        )->withTimestamps();
    }
}
