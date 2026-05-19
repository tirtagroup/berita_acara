<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_Emp_Assesment extends Model
{
  protected $table = 'tr_emp_assesment';
  protected $fillable = [
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
      'ms_periode'

  ];
}
