<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_BA_Main_New extends Model
{
  protected $table = 'Tr_Ba_Main_New';
  protected $fillable = [
    'Tr_BA_Main_Code',
    'Ms_BA_type_Code',
    'Ms_Emp_Code',
    'Ms_Emp_Div',
    'Ms_Pelapor_Code',
    'Ms_Pelapor_Div',
    'BA_Desc',
    'CekPelanggaran',
    'CekKerusakan',
    'CekFraud',
    'CekRevisi',
    'CekDisiplin',
    'CekSalahIsi',
    'CekNoClosing',
    'CekLaka',
    'CekPembelian',
    'CekKehilangan',	
    'CekPerubahanSOP',
    'Ms_Kasus',
    'MS_Detail_Kasus',	
    'Tr_EmpPeriod_Code',
    'rec_usercreated',	
    'rec_userupdate',
    'rec_datecreated',
    'rec_dateupdate',
    'rec_comcode',
    'rec_areacode',
    'rec_status',
    'created_at',
    'updated_at'
  ];
}
