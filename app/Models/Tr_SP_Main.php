<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_SP_Main extends Model
{
  protected $table = 'tr_acc_sp_main';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'rec_usercreated',
      'rec_userupdate',
      'rec_datecreated',
      'rec_dateupdate',
      'rec_status',
      'ms_company',
      'ms_lokasi',
      'sp_main_code',
      'sp_type',
      'sp_jenis',
      'ms_employee',
      'ms_divisi',
      'sp_desc',
      'masa_berlaku'
  ];
}
