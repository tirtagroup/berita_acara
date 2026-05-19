<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $table = 'candidate_organisasi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'Ktp ',
        'Nama_organisasi',
        'Jabatan',
        'Periode'
    ];
}
