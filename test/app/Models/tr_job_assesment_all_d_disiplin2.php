<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_job_assesment_all_d_disiplin2 extends Model
{
    use HasFactory;
    protected $table = 'tr_ass_d_disiplin2';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'tr_assessment_code_h',
        'tr_assestment_code_d',
        'ass_employeecode',
        'ass_absen2',
        'ass_report2',
        'ass_rajin2',
        'ass_note2'
    ];
}
