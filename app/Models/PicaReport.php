<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Structured PICA report (compiled).
 * 1 row per PICA, dengan section A, B, F, G inline.
 * Section C (5Why) di tr_pica_report_why, D+E (actions) di tr_pica_report_action.
 */
class PicaReport extends Model
{
    protected $table = 'tr_pica_reports';

    protected $fillable = [
        'tr_pica_main_code',
        // Section A
        'section_a_what', 'section_a_when', 'section_a_where',
        'section_a_who', 'section_a_why_awal', 'section_a_how', 'section_a_howmuch',
        // Section B
        'section_b_man', 'section_b_machine', 'section_b_material',
        'section_b_method', 'section_b_environment',
        // Section F
        'section_f_kpi', 'section_f_review_schedule', 'section_f_audit_result',
        // Section G
        'section_g_approver_id', 'section_g_closure_date',
        'section_g_pelajaran', 'section_g_dokumentasi_path',
        // Meta
        'compiled_by', 'compiled_at',
    ];

    protected $casts = [
        'section_g_closure_date' => 'date',
        'compiled_at'            => 'datetime',
    ];

    public function whys(): HasMany
    {
        return $this->hasMany(PicaReportWhy::class, 'report_id')->orderBy('urutan');
    }

    public function correctives(): HasMany
    {
        return $this->hasMany(PicaReportAction::class, 'report_id')
                    ->where('tipe', 'corrective')
                    ->orderBy('urutan');
    }

    public function preventives(): HasMany
    {
        return $this->hasMany(PicaReportAction::class, 'report_id')
                    ->where('tipe', 'preventive')
                    ->orderBy('urutan');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'section_g_approver_id');
    }

    public function compiler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'compiled_by');
    }
}
