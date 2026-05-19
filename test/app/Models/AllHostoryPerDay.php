<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllHostoryPerDay extends Model
{
  protected $table = 'AllHostoryPerDay';
  protected $fillable = [
      'lowongan ',
      'tanggal_main',
      'total_lamar',
      'total_panggil',
      'total_interview',
      'total_ok_calls',
      'total_ok_interview'
  ];
}
