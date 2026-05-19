<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsDivisi extends Model
{
  protected $table = 'ms_division';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'rec_usercreated',
      'rec_userupdate',
      'rec_datecreated',
      'rec_dateupdate',
      'rec_status',
      'div_code',
      'div_desc',
      'created_at',
      'updated_at'

  ];
}
