<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_PICA_Emp_h extends Model
{
  protected $table = 'Tr_PICA_Emp_h';
  protected $primaryKey = 'Tr_Pica_Emp_h_Code';
  protected $keyType = 'string';
  protected $fillable = [
   'Tr_Pica_Emp_h_Code',
   'Emp_Code',
   'Date_PICA',
   'SPV_Approval',
   'Problem_Note',
   'User_Created',
   'User_Update',
   'Ms_Company',
   'Ms_Location',
   'Status_PICA',
   'Tanggung_Jawab',
   'Target',
   'Apakah_Sudah_Pernah_Kejadian',
   'Imbas_Dari_Kejadian',
   'Siapa_YgTerkenaImbas_Kejadian',
    'Kapan_Terjadi',


  ];
}
