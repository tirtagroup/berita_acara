<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_Memo extends Model
{
    // use HasFactory;
    protected $table = 'tr_reportmemos';
    protected $fillable = [
        'Tr_ReportMemo ',
        'Tr_report_main_code',
        'Ms_User_Code',
        'rec_comcode',
        'rec_areacode',
        'ms_divisi',
        'Ms_ReportType_Code',
        'Memo'
    ];
}
