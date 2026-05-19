<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BusinessUnit extends Model
{
    protected $table = 'ms_business_unit';

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
        return $this->hasMany(BuKategoriMapping::class, 'bu_id');
    }

    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(
            BaKategori::class,
            'ms_bu_kategori_mapping',
            'bu_id',
            'kategori_id'
        )->withPivot('level')->withTimestamps();
    }
}
