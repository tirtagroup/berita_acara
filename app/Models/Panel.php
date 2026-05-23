<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Panel/module aplikasi (BA_LIST, MASTER_KONTEKS, dll).
 */
class Panel extends Model
{
    protected $table = 'ms_panel';

    protected $fillable = [
        'kode', 'nama', 'parent_id', 'modul', 'url', 'icon', 'urutan',
        'scopable', 'supported_scopes', 'active',
    ];

    protected $casts = [
        'scopable'         => 'boolean',
        'active'           => 'boolean',
        'urutan'           => 'integer',
        'supported_scopes' => 'array',
    ];

    public const MODULS = ['BA', 'PICA', 'MASTER', 'HELP', 'UMUM'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
