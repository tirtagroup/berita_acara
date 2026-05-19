<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_BA_Category extends Model
{
  protected $table = 'ms_case_category';
  protected $fillable = [
      'Ms_BA_category_Code',
      'BA_Type_Desc'
  ];
}
