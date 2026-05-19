<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_Period_asssement extends Model
{
  protected $table = 'tr_period_asssement';
  protected $primaryKey = 'Tr_period_assement';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_code_main_assessment',
      'Tr_period_assement',
      'tugas',
      'start_date',
      'EndDate'

  ];
}
