<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_emp_asses_advance_result extends Model
{
  protected $table = 'tr_emp_asses_advance_result';
  protected $fillable = [
    'id_adv_rst',
    'Ms_Emp_Assessor_Code',
    'mengarahkan_value',
    'mengarahkan_comment',
    'problem_solving_value',
    'problem_solving_comment',
    'planning_value',
    'planning_comment',
    'analisa_value',
    'analisa_comment',
    'kualitas_komunikasi_value',
    'kualitas_komunikasi_comment'
  ];
}
