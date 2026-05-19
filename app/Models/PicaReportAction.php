<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicaReportAction extends Model
{
    protected $table = 'tr_pica_report_action';

    protected $fillable = [
        'report_id',
        'tipe',          // 'corrective' | 'preventive'
        'deskripsi',
        'pic_user_id',
        'deadline',
        'status',        // 'pending' | 'in_progress' | 'done' | 'cancelled'
        'completed_at',
        'notes',
        'urutan',
    ];

    protected $casts = [
        'deadline'     => 'date',
        'completed_at' => 'date',
        'urutan'       => 'integer',
    ];

    public const TIPE_CORRECTIVE = 'corrective';
    public const TIPE_PREVENTIVE = 'preventive';

    public const STATUS_PENDING     = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE        = 'done';
    public const STATUS_CANCELLED   = 'cancelled';

    public function report(): BelongsTo
    {
        return $this->belongsTo(PicaReport::class, 'report_id');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }
}
