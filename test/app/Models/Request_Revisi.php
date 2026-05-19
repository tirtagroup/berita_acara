<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request_Revisi extends Model
{
    protected $table = 'tr_ba_request_revisi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'user_created',
        'user_updated',
        'rec_status',
        'rec_datecreated',
        'rec_dateupdate',
        'tr_ba_request_revisi_code',
        'tr_ba_main_code',
        'note'
    ];
}
