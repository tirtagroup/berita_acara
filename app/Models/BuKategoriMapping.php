<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuKategoriMapping extends Model
{
    protected $table = 'ms_bu_kategori_mapping';

    protected $fillable = [
        'bu_id',
        'kategori_id',
        'level',
    ];

    public const LEVEL_WAJIB      = 'wajib';
    public const LEVEL_DISARANKAN = 'disarankan';
    public const LEVEL_OPSIONAL   = 'opsional';

    public const LEVELS = [
        self::LEVEL_WAJIB,
        self::LEVEL_DISARANKAN,
        self::LEVEL_OPSIONAL,
    ];

    public function businessUnit(): BelongsTo
    {
        return $this->belongsTo(BusinessUnit::class, 'bu_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BaKategori::class, 'kategori_id');
    }
}
