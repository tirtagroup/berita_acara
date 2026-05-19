<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_job_assesment_all_d_disiplin extends Model
{
    protected $table = 'tr_ass_d_disiplin1';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'tr_assestment_code_h',
        'tr_assestment_code_d',
        'ass_employeecode',
        'ass_absen',
        'ass_report',
        'ass_rajin',
        'ass_note'
    ];
}
