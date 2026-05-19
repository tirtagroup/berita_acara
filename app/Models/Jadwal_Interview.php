<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_Interview extends Model
{
  protected $table = 'tr_int_sched';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'tr_int_sched_Code',
      'Date_int',
      'Time_int',
      'Interviewer',
      'Lokasi',
      'Ms_Candidate_Code',
      'Int_model'
  ];
}
