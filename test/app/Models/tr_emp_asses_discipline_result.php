<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_emp_asses_discipline_result extends Model
{
  protected $table = 'tr_emp_asses_discipline_result';
  protected $fillable = [
        'id_dcpn_rst',
        'id_emp_asses',
        'Tr_Emp_Asses_Code',
        'Ms_Emp_Assessor_Code',
        'absensi_value',
        'absensi_comment',
        'report_value',
        'report_comment',
        'kerajinan_value',
        'kerajinan_comment'
  ];
}
