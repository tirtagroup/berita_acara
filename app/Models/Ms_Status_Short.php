<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_Status_Short extends Model
{
  protected $table = 'ms_status_short';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'status_code',
      'status_desc',
      'rec_status',
      'user_created',
      'user_updated',
      'created_at',
      'updated_at'

  ];
}
