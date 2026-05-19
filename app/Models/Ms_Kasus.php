<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_Kasus extends Model
{
  protected $table = 'ms_kasus';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'ms_kasus_code',
      'description',
      'rec_status',
      'created_at',
      'updated_at'

  ];
}
