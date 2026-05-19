<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_review_empperiod_task_reviewer extends Model
{
  protected $table = 'Tr_Review_EmpPeriod_Task_Reviewer';
  protected $primaryKey = 'Tr_Review_EmpPeriod_Task_Reviewer_Code';
  protected $keyType = 'string';
  protected $fillable = [
      'Tr_Review_EmpPeriod_Task_Reviewer_Code',
      'Tr_Review_EmpPeriod_Code_h',
      'TaskDesc',
      'DateTask',
      'Ms_Reviewer_Code',
      'Ms_Task_Status',
      'Quality',
      'ResultDesc',
      'ResultHigh',
      'ResultLow',
      'SugestReviewer',
      'SuggestMgt',
      'Suggest_BOD'
  ];
}
