<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_Jenis_BA extends Model
{
    protected $table = 'ms_kasus_head';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id ',
        'ms_jenis_ba_code',
        'description',
        'rec_usercreated',
        'rec_userupdate',
        'rec_status',
        'created_at',
        'updated_at'
  
    ];
}
