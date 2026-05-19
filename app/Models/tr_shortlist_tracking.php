<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_shortlist_tracking extends Model
{
  protected $table = 'tr_shortlist_tracking';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'rec_usercreated',
      'rec_userupdate',
      'rec_datecreated',
      'rec_dateupdate',
      'rec_status',
      'tracking_code',
      'ms_status_short',
      'kandidat',
      'no_hp',
      'email'
  ];
}
