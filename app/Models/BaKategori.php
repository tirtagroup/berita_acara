<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaKategori extends Model
{
    protected $table = 'ms_ba_kategori';

    protected $fillable = [
        'kode',
        'nama',
        'parent_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Opsi-opsi yang attach ke kategori ini (N:M via pivot).
     * Pivot punya kolom: kode, sort_order, active.
     */
    public function opsi(): BelongsToMany
    {
        return $this->belongsToMany(
            BaKategoriOpsi::class,
            'ms_kategori_opsi_mapping',
            'kategori_id',
            'opsi_id'
        )->withPivot('kode', 'sort_order', 'active')
         ->withTimestamps()
         ->orderBy('ms_kategori_opsi_mapping.sort_order');
    }

    public function konteksList(): BelongsToMany
    {
        return $this->belongsToMany(
            Konteks::class,
            'ms_konteks_kategori_mapping',
            'kategori_id',
            'konteks_id'
        )->withPivot('level')->withTimestamps();
    }

    public function baPivotEntries(): HasMany
    {
        return $this->hasMany(TrBaKategoriD::class, 'kategori_id');
    }
}
