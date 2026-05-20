<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mapping flag legacy Tr_Ba_Main_New.Cek* → kategori v2 (+ opsional opsi).
 * Dipakai oleh artisan command `ba:migrate-cek-flags`.
 */
class CekFlagMapping extends Model
{
    protected $table = 'ms_cek_flag_mapping';

    protected $fillable = [
        'legacy_flag',
        'kategori_kode',
        'opsi_kode',
        'active',
        'notes',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public const LEGACY_FLAGS = [
        'CekPelanggaran', 'CekKerusakan', 'CekFraud', 'CekRevisi',
        'CekDisiplin', 'CekSalahIsi', 'CekNoClosing', 'CekLaka',
        'CekPembelian', 'CekKehilangan', 'CekPerubahanSOP',
    ];
}
