<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_BA_Kronologi extends Model
{
  protected $table = 'tr_ba_kronologi';
  protected $fillable = [
      'tr_ba_kronologi_code ',
      'tr_ba_main_code',
      'kronlogi'
  ];
}
