<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_belum_shortlist extends Model
{

  protected $table = 'hrd_main_belum_shortlist';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'Name',
      'domisili',
      'Birthdate',
      'umur',
      'jenis_kelamin',
      'agama',
      'Handphone',
      'Position_aplly1',
      'created_at',
      'Perusahaan'
  ];
}
