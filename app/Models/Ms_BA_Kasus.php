<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_BA_Kasus extends Model
{
  protected $table = 'ms_kasus_head';
  protected $fillable = [
      'ms_type',
      'ms_jenis_ba_code',
      'description',
      'rec_status',
      'rec_usercreated',
      'rec_userupdate'
  ];
}
