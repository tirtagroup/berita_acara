<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_docs extends Model
{
  protected $table = 'ba_document';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id',
      'ba_main_code',
      'file_path',
      'create_at',
      'updated_at'
  ];
}
