<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi2 extends Model
{
    protected $table = 'candidate_organisasi2';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'Nama_organisasi2',
        'Jabatan2',
        'Periode2'
    ];
}
