<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_review_empperiod_h extends Model
{
  protected $table = 'Tr_Review_EmpPeriod_h';
  protected $primaryKey = 'Tr_Review_EmpPeriod_Code_h';
  protected $keyType = 'string';
  protected $fillable = [
      'Tr_Review_EmpPeriod_Code_h',
      'Ms_Emp_Code',
      'Ms_Emp_Div',
      'Ms_Periode',
      'Year_Desc',
      'Date_Asses',
      'Period',
      'rec_status'
  ];
}
