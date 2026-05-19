<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_q1_user_assesor_h extends Model
{
  protected $table = 'tr_q1_user_assesor_h';
  protected $primaryKey = 'Tr_Q1_User_Assesor_H_Code';
  protected $keyType = 'string';
  protected $fillable = [
      'Tr_Q1_User_Assesor_H_Code',
      'Tr_Assessment_Main_Code',
      'Ms_periode',
      'Ms_Employee',
      'Ms_Assessor'

  ];
}
