<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_period_emp extends Model
{
  protected $table = 'tr_period_emp';
  protected $primaryKey = 'tr_period_emp_code';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_period_emp_code',
      'start_date',
      'ms_emp_code'
  ];
}
