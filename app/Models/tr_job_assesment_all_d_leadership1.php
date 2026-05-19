<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_job_assesment_all_d_leadership1 extends Model
{
  protected $table = 'tr_ass_d_leadership1';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_assestment_code_h',
      'tr_assestment_code_d',
      'ass_employeecode',
      'ass_mengarahkan',
      'ass_problem_solving',
      'ass_planning',
      'ass_analisa',
      'ass_kualitas_komunikasi',
      'ass_note'
  ];
}
