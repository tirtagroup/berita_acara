<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_job_assesment_all_h_basic2 extends Model
{
  protected $table = 'tr_ass_h_basic2';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'rec_usercreated',
      'rec_userupdate',
      'rec_datecreated',
      'rec_dateupdate',
      'rec_status',
      'tr_assessment_code_h',
      'tr_assessment_code_main',
      'Ass_desc',
      'Ass_periode',
      'Ass_date',
      'Ass_assestcode',
      'Ass_div'
  ];
}
