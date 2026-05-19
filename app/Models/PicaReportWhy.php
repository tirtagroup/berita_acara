<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicaReportWhy extends Model
{
    protected $table = 'tr_pica_report_why';

    protected $fillable = [
        'report_id',
        'urutan',
        'pertanyaan',
        'jawaban',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(PicaReport::class, 'report_id');
    }
}
