<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_period_emp_task extends Model
{
  protected $table = 'tr_period_emp_task';
  protected $primaryKey = 'Tr_period_emp_task_code';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_code_main_assessment',
      'Tr_period_emp_task_code',
      'Task',
      'Ms_Order_giver',
      'Tr_period_emp_Code',
      'initiative',
      'mentoring',
      'start_date',
      'end_date',
      'Date',
      'ms_type',
      'status',
      'konsisten',
      'akurasi',
      'tepatwaktu',
      'quality'

  ];
}
