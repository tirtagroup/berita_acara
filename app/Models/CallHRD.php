<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallHRD extends Model
{
    protected $table = 'tr_candidate_call';
    protected $fillable = [
        'Ms_User_Code',
        'ms_divisi',
        'Tr_Report_Lowongan_Call',
        'Tr_report_hrd_main_code',
        'Nama_kandidat',
        'Ms_Media_Code',
        'NamaLowongan ',
        'Telepon',
        'Ms_Status',
        'Ms_ReportType_Code',
        'Tr_status_interview'
    ];
}
