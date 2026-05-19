<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicaJawaban extends Model
{
    protected $table = 'tr_pica_jawaban';

    protected $fillable = [
        'pertanyaan_id',
        'user_id',
        'jawaban',
        'ack_status',
        'is_final',
    ];

    protected $casts = [
        'is_final' => 'boolean',
    ];

    public const ACK_SETUJU      = 'setuju';
    public const ACK_TIDAK_SETUJU = 'tidak_setuju';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(PicaPertanyaan::class, 'pertanyaan_id');
    }
}
