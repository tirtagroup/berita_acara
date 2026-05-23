<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Action master: view, create, edit, delete, approve, sign, close, export, dll.
 */
class Action extends Model
{
    protected $table = 'ms_action';

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'urutan', 'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'urutan' => 'integer',
    ];
}
