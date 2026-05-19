<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_job_assesment_all_d_basic2 extends Model
{
  protected $table = 'tr_ass_d_basic2';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_assestment_code_h',
      'tr_assestment_code_d',
      'ass_employeecode',
      'ass_trust',
      'ass_Drive',
      'ass_basic',
      'ass_inisiatif',
      'ass_hasil',
      'ass_skill',
      'ass_note'
  ];
}
