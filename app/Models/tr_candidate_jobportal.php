<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_candidate_jobportal extends Model
{
  protected $table = 'tr_candidate_jobportal';
  public $fillable = [
      'Name',
      'Ktp',
      'domisili',
      'CityBirth',
      'Birthdate',
      'status',
      'jenis_kelamin',
      'agama',
      'Handphone',
      'Email',
      'pengajuan_gaji',
      'Info_lowongan',
      'Position_aplly1',
      'ketersediaan',
      'layak',
      'patner',
      'pasfoto',
      'photo',
      'rec_status'
  ];
}
