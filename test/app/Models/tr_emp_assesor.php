<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_emp_assesor extends Model
{
  protected $table = 'tr_emp_assesor';
  protected $fillable = [
      'id_emp_accessor',
      'rec_usercreated',
      'rec_userupdate',
      'rec_datecreated',
      'rec_dateupdate',
      'rec_status',
      'Tr_Emp_Asses_Code',
      'Ms_Emp_Assessor_Code',
      'Date_Asses',
      'Ms_emp_code',
      'Ms_Emp_Div'
  ];
}
