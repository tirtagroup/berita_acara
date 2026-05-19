<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_Pica_Emp_D extends Model
{
  protected $table = 'Tr_Pica_Emp_D';
  protected $primaryKey = 'Tr_Pica_emp_d_Code';
  protected $keyType = 'string';
  protected $fillable = [
    'Tr_Pica_emp_d_Code',
    'Tr_Pica_emp_h_Code',
    'NoBA',
    'ApaYangSalah',
    'MengapaTerjadi',
    'BagaimanaMenghindari',
    'ApaYangDiperhatikan',
    'Siapa_Yang_Salah',
    'ApaSajaYangMenyebkanKejadian',
    'Apakah_Sudah_Pernah_Kejadian',
    'created_at',
    'updated_at'
  ];
}
