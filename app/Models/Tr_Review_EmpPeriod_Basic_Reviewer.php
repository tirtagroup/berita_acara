<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_review_empperiod_basic_reviewer extends Model
{
  protected $table = 'Tr_Review_EmpPeriod_Basic_Reviewer';
  protected $primaryKey = 'Tr_Review_EmpPeriod_Basic_Reviewer_Code';
  protected $keyType = 'string';
  protected $fillable = [
      'Tr_Review_EmpPeriod_Basic_Reviewer_Code',
      'DateReviewBasic',
      'Tr_Review_EmpPeriod_Code_h',
      'Ms_Reviewer_Code',
      'Trust_value',
      'TrustHigh',
      'TrustLow',
      'drive_value',
      'DriveHigh',
      'DriveLow',
      'inisiative_value',
      'InisiativeHigh',
      'InisitativeLow',
      'Reliable_value',
      'ReliableHigh',
      'ReliableLow',
      'result',
      'ResultHigh',
      'ResultLow'
  ];
}
