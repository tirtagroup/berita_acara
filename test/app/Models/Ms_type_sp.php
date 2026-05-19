<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_type_sp extends Model
{
  protected $table = 'ms_type_sp';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'type_code',
      'description',
      'rec_status',
      'user_created',
      'user_updated',
      'created_at',
      'updated_at'

  ];
}
