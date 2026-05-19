<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_reportHRD extends Model
{
    protected $table = 'tr_report_hrd_main';
    protected $fillable = [
        'Tr_report_hrd_main_code ',
        'Ms_ReportType_Code',
        'Ms_User_Code',
        'ms_divisi',
        'ms_lokasi',
        'Ms_Perusahaan_Code_main'
    ];
}
