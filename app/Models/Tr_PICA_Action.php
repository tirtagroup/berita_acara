<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_PICA_Action extends Model
{
  protected $table = 'Tr_PICA_Action';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'Tr_Pica_Action_Code',
      'Tr_Pica_Emp_h_Code',
      'Tr_PICA_Emp_h',
      'ApaYangAkanDilakukan',
      'Kapan'
  ];
}
