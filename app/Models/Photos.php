<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $table = 'candidate_photos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id ',
        'Ktp',
        'file_path',
        'create_at',
        'updated_at'
    ];
}
