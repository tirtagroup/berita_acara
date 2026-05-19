<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicaParticipant extends Model
{
    protected $table = 'tr_pica_participants';

    protected $fillable = [
        'tr_pica_main_code',
        'user_id',
        'role',
    ];

    public const ROLE_PELAKU = 'pelaku';
    public const ROLE_PIC    = 'pic';
    public const ROLE_DEWAN  = 'dewan';
    public const ROLES = [self::ROLE_PELAKU, self::ROLE_PIC, self::ROLE_DEWAN];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
