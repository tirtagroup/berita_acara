<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumVitae extends Model
{
    protected $table = 'candidate_cv';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id ',
        'Ktp',
        'file_cv',
        'create_at',
        'updated_at'
    ];
}
