<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_emp_asses_basic_result extends Model
{
  protected $table = 'tr_emp_asses_basic_result';
  protected $fillable = [
      'id_bsc_rst',
      'Tr_Emp_Asses_Code',
      'Ms_Emp_Assessor_Code',
      'Trust_value',
      'trust_comment',
      'trust_suggestion',
      'drive_value',
      'drive_comment',
      'drive_suggestion',
      'inisiative_value',
      'inisiatif_comment',
      'inisiative_suggestion',
      'Reliable_value',
      'reliable_comment',
      'Reliable_suggestion',
      'reslut',
      'result_comment',
      'result_suggestion'
  ];
}
