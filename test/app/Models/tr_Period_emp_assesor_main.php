<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_Period_emp_assesor_main extends Model
{
  protected $table = 'tr_period_emp_assesor_main';
  protected $fillable = [
      'id_period_emp_assesor ',
      'rec_usercreated',
      'rec_userupdate',
      'rec_datecreated',
      'rec_dateupdate',
      'rec_status',
      'Date_Asses',
      'Tr_Emp_Asses_Code',
      'Ms_Emp_Code',
      'Ms_Emp_Div',
      'Ms_type_asses',
      'Ms_record_asses',
      'ms_periode',
      'MS_Assesor_Code',
      'Ms_User_Code',
      'Period',
      'Tr_Period_Emp_Code'

  ];
}
