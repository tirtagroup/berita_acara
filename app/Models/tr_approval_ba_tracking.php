<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_approval_ba_tracking extends Model
{
  protected $table = 'tr_approval_ba_tracking';
  protected $fillable = [
      'rec_comcode',
      'approval_ba_code',
      'approval_ba_main_code',
      'approval_ba_tracking',
      'approval_ba_desc',
      'pic',
      'approval_ba_divisi',
      'note',
      'status_approve'
  ];
}
