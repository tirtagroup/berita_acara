<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class babydivisi_permonth extends Model
{
  protected $table = 'babydivisi_permonth';
  protected $fillable = [
    'Division_Code',
    'total_ba'
];
}
