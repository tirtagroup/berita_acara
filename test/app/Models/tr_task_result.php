<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_task_result extends Model
{
  protected $table = 'tr_task_result';
  protected $primaryKey = 'tr_period_emp_task_assesor';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_code_main_assessment',
      'tr_period_emp_task',
      'tr_period_emp_task_assesor',
      'ms_assesor_code',
      'Jobs',
      'ResultNote',
      'ScoreResult',
      'Date'

  ];
}
