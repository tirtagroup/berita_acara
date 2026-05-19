<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_BA_Detail_Kasus extends Model
{
  protected $table = 'ms_kasus';
  protected $fillable = [
      'ms_kasus_code',
      'ms_kasus_head1',
      'description',
      'rec_status',
      'rec_usercreated',
      'rec_userupdate'
  ];
}
