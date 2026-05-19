<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_PICA_Preventive_Action extends Model
{
  protected $table = 'Tr_PICA_Preventive_Action';
  protected $primaryKey = 'Tr_PICA_Preventive_Action_Code';
  protected $keyType = 'string';
  protected $fillable = [
   'Tr_PICA_Preventive_Action_Code',
   'Tr_Pica_emp_h_Code',
   'Tr_Preventive'

  ];
}
