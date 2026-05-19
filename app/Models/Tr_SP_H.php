<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_SP_H extends Model
{
  protected $table = 'tr_acc_sp_h';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'rec_usercreated',
      'rec_userupdate',
      'rec_datecreated',
      'rec_dateupdate',
      'rec_status',
      'tr_acc_sp_h_code',
      'tr_acc_sp_main_code',
      'rec_comcode',
      'rec_areacode',
      'sp_employee',
      'sp_divisi'
  ];
}
