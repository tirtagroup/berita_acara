<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ms_kode_interview extends Model
{
  protected $table = 'ms_kode_interview';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'created_at',
      'updated_at',
      'rec_usercreated',
      'rec_userupdate',
      'rec_status',
      'ms_kode_interview_code',
      'desciption'

  ];
}
