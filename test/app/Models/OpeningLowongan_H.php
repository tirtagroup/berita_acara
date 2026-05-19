<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningLowongan_H extends Model
{
     // use HasFactory;
     protected $table = 'tr_report_lowongan_h';
     protected $fillable = [
         'Tr_report_lowongan_code_h ',
         'Date_created',
         'Ms_operator',
         'Date_lowongan',
         'Total_opening',
         'Total_opening_HGS',
         'Total_opening_TGF',
         'Total_opening_TGU
         '
     ];
}
