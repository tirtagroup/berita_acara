<?php

namespace App\Models;

use App\Models\tr_candidate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidate_photos extends Model
{
    use HasFactory;
    public $table = 'candidate_photos';  
    protected $primaryKey = 'id';

    public function tr_candidate()
    {
        return $this->belongsTo(tr_candidate::class);
    }
}
