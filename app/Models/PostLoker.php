<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLoker extends Model
{
    use HasFactory;

    protected $table = 'tr_lowongan_main';
    protected $fillable = [
        'id',
        'Tr_Lowongan_Code',
        'Ms_Company_code',
        'PosisiDesc',  
        'Date_Lowongan',
        'Date_Expired',
        'Posisi',
        'SendTo',
        'EmailTo',
        'RequirementDesc'      

    ];
}
