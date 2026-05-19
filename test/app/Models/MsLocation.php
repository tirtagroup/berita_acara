<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsLocation extends Model
{
  protected $table = 'ms_lokasi';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'lokasi_code',
      'lokasi_desc',
      'lokasi_kota',
      'no_hp',
      'area_code',
      'company_code',
      'user_created',
      'user_updated'
  ];
}
