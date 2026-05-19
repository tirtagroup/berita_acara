<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_Call_H extends Model
{
    protected $table = 'tr_candidate_call_h';
    protected $fillable = [
        'tr_candidate_call_code_h ',
        'Ms_Caller_code',
        'Date_Call',
        'Total_Call_HGS',
        'Total_Call_TGU',
        'Total_Call_TGF',
        'Total_Call'
    ];
}
