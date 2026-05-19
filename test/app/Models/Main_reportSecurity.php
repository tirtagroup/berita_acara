<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_reportSecurity extends Model
{
    protected $table = 'tr_report_security_main';
    protected $fillable = [
        'Tr_report_security_main_code ',
        'Ms_ReportType_Code',
        'Ms_User_Code',
        'ms_divisi',
        'ms_lokasi'
    ];
}
