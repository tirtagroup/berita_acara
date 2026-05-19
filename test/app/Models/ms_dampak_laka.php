<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ms_dampak_laka extends Model
{
  protected $table = 'ms_dampak_laka';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'ms_dampak_laka_code',
      'description',
      'rec_usercreated',
      'rec_userupdate',
      'rec_status',
      'created_at',
      'updated_at'

  ];
}
