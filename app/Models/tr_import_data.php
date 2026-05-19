<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_import_data extends Model
{
  protected $table = 'tr_import_data';
  protected $fillable = [
      'full_name',
      'email',
      'address',
      'location',
      'cell_phone',
      'gender',
      'birthdate',
      'current_sallary',
      'current_sallary2',
      'expected_sallary',
      'last_job',
      'last_company',
      'last_education',
      'last_major',
      'last_school',
      'efset',
      'communication_test',
      'interest_test',
      'tld_1',
      'orvi',
      'apply_at',
      'matched',
      'shortlisted',
      'not_matched',
      'orvi2',
      'interview1',
      'interview2',
      'interview3',
      'mcu',
      'tld2',
      'offered',
      'hired',
      'failed',
      'image',
      'applied_position',
      'last_gpa',
      'keterangan'
  ];
}
