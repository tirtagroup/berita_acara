<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class babydivisi extends Model
{
  protected $table = 'babydivisi';
  protected $fillable = [
    'Division_Code',
    'total_ba'
];
}
