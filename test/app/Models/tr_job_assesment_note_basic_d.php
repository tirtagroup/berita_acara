<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_job_assesment_note_basic_d extends Model
{
  protected $table = 'tr_job_assesment_note_basic_d';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'Tr_Job_Assesment_all_code',
      'Date_Job_Assesement',
      'User_Create_Code',
      'User_Create_Code_Div',
      'Atasan_Code',
      'Atasan1_Code',
      'Atasan2_Code',
      'HRD_Code',
      'InisiativeUser',
      'Reliable',
      'Communication',
      'Highlite',
      'LowLIte',
      'Completeness',
      'InisiatifAtasan',
      'InisiatiffAtasan2',
      'ms_divisi',
      'rec_usercreate',
      'rec_userupdate',
      'rec_status',
      'created_at'
  ];
}
