<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PicaPertanyaanMaster extends Model
{
    protected $table = 'ms_pica_pertanyaan_master';

    protected $fillable = [
        'kode',
        'pertanyaan',
        'tipe',
        'scope',
        'urutan',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'urutan' => 'integer',
    ];

    public const TIPE_PERTANYAAN = 'pertanyaan';
    public const TIPE_PERNYATAAN = 'pernyataan';
    public const TIPES = [self::TIPE_PERTANYAAN, self::TIPE_PERNYATAAN];

    public const SCOPE_WAJIB = 'wajib_universal';
    public const SCOPE_BANTUAN = 'bantuan';
    public const SCOPES = [self::SCOPE_WAJIB, self::SCOPE_BANTUAN];
}
