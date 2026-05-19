<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_ba_revisi extends Model
{
  protected $table = 'tr_ba_revisi';
  protected $fillable = [
    'Cek_Spv_Approval',
    'Date_SPV_Approved',
    'Spv_Code',
    'Spv_Note',	
    'Cek_HR_Approval',
    'Date_HR_Approved',
    'HR_Code',	
    'HR_Note'
  ];
}

