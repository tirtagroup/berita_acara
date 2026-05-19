<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class babydivisi_perday extends Model
{
  protected $table = 'babydivisi_perday';
  protected $fillable = [
    'Division_Code',
    'total_ba'
];
}
