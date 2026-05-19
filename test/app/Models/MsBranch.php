<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsBranch extends Model
{
  protected $table = 'ms_branch';
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  protected $fillable = [
      'id ',
      'branch_code',
      'description',
      'rec_status',
      'user_created',
      'user_updated',
      'created_at',
      'updated_at'

  ];
}
