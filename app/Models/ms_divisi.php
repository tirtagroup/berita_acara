<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ms_divisi extends Model
{
  protected $table = 'ms_divisi';
  protected $fillable = [
      'subbdiv_code ',
      'subbdiv_desc',
      'user_created',
      'user_updated'
  ];
}
