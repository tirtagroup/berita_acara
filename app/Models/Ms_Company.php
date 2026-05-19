<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_Company extends Model
{
  protected $table = 'ms_company';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'company_code',
      'description',
      'rec_status',
      'user_created',
      'user_updated',
      'created_at',
      'updated_at'

  ];
}
