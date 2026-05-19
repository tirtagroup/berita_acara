<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_SP_D extends Model
{
  protected $table = 'tr_acc_sp_d';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_acc_sp_d_code',
      'tr_acc_sp_h_code',
      'sp_note'
  ];
}
