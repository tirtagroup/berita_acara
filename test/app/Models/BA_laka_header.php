<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_laka_header extends Model
{
  protected $table = 'tr_ba_laka_h';
  protected $fillable = [
      'tr_ba_laka_code ',
      'ms_jenis_laka',
      'ms_faktor_laka',
      'ms_klasifikasi_laka',
      'ms_dampak_laka',
      'type_laka',
      'pool',
      'dispatcher',
      'spk',
      'no_armada',
      'jam_keluar',
      'jam_kejadian',
      'rallying ',
      'speed',
      'in_pool',
      'out_pool',
      'rute',
      'bengkel_terakhir',
      'lokasi_kejadian',
      'date_laka',
      'fatality'

  ];
}
