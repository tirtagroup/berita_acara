<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_OpeningHRD extends Model
{
    protected $table = 'tr_report_lowongan_d';
    protected $fillable = [
        'Ms_User_Code',
        'ms_divisi',
        'Tr_ReportLowongan_Code',
        'Tr_report_hrd_main_code',
        'Ms_Media_Code ',
        'Ms_Perusahaan_Code',
        'MS_Jabatan_Code',
        'Qty',
        'tr_Lowongan_Code_H',
        'Ms_ReportType_Code'
    ];
}
