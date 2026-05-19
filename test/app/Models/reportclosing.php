<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reportclosing extends Model
{
  protected $table = 'reportclosing';
  protected $fillable = [
      'Ms_User_Code',
      'ms_divisi',
      'ms_lokasi',
      'total_open',
      'total_panggil',
      'total_interview',
      'total_interview_diterima',
      'tanggal_main'
  ];
}
