<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_laka_detail extends Model
{
    protected $table = 'tr_ba_laka_d';
    protected $fillable =
    [
      'tr_ba_laka_code_h ',
      'posisi',
      'nama',
      'usia',
      'penguji',
      'avg_income',
      'istirahat_last'
    ];
}
