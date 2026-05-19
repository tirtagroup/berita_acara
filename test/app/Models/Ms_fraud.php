<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_fraud extends Model
{
  protected $table = 'ms_fraud';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'ms_fraud_code',
      'ms_fraud_desc',
      'rec_usercreated',
      'rec_userupdate',
      'rec_status',
      'created_at',
      'updated_at'

  ];
}
