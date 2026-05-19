<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_PICA_Pertanyaan extends Model
{
  protected $table = 'Tr_PICA_Pertanyaan';
  protected $primaryKey = 'Tr_PICA_Pertanyaan_Code';
  protected $keyType = 'string';
  protected $fillable = [
   'Tr_PICA_Pertanyaan_Code',
   'Tr_Pica_emp_h_Code',
   'Tr_Pertanyaan',
   'Tr_Jawaban'

  ];
}
