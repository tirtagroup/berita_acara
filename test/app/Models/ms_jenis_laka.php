<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ms_jenis_laka extends Model
{
  protected $table = 'ms_jenis_laka';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'ms_jenis_code',
      'description',
      'rec_usercreated',
      'rec_userupdate',
      'rec_status',
      'created_at',
      'updated_at'

  ];
}
