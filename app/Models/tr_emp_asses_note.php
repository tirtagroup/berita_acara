<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_emp_asses_note extends Model
{
  protected $table = 'tr_emp_asses_note';
  protected $fillable = [
      'id_accessor_nt',
      'Tr_Emp_Asses_Code',
      'Ms_Emp_Assessor_Code',
      'note',
      'ms_type',
      'rating',
      'deadline',
      'status'
  ];
}
