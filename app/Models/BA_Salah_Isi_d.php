<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_Salah_Isi_d extends Model
{
    protected $table = 'tr_ba_salah_isi_detail';
    protected $fillable = [
      'tr_ba_code_main',
      'tr_ba_code_request',
      'code_ba',
      'code_doc',
      'field_salah',
      'value_salah',
      'field_benar',
      'value_benar'
  ];
}
