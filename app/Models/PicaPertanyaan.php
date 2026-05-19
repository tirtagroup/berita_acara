<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Pertanyaan transactional per-PICA.
 * Tabel: tr_pica_pertanyaan_d
 *
 * Source:
 *   - pertanyaan_master_id NOT NULL → linked dari master (ms_pica_pertanyaan_master)
 *   - pertanyaan_master_id NULL     → bebas / ad-hoc
 */
class PicaPertanyaan extends Model
{
    protected $table = 'tr_pica_pertanyaan_d';

    protected $fillable = [
        'tr_pica_main_code',
        'pertanyaan_master_id',
        'pertanyaan',
        'tipe',
        'wajib_jawab',
        'urutan',
        'created_by',
    ];

    protected $casts = [
        'wajib_jawab' => 'boolean',
        'urutan'      => 'integer',
    ];

    public function master(): BelongsTo
    {
        return $this->belongsTo(PicaPertanyaanMaster::class, 'pertanyaan_master_id');
    }

    public function jawabans(): HasMany
    {
        return $this->hasMany(PicaJawaban::class, 'pertanyaan_id')->orderBy('created_at');
    }

    /**
     * Jawaban final dari pelaku (is_final = true).
     */
    public function jawabanFinal(): ?PicaJawaban
    {
        return $this->jawabans()->where('is_final', true)->first();
    }

    public function isBebas(): bool
    {
        return is_null($this->pertanyaan_master_id);
    }
}
