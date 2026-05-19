<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_BA_Comment extends Model
{
  protected $table = 'Tr_BA_Comment';
  protected $fillable = [
      'Tr_BA_Comment_Code',
      'Tr_BA_Main_Code',
      'Comment',
      'status_melihat',
      'Ms_User'
  ];
}

