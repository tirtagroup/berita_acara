<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Tier user (SUPER_ADMIN, ADMIN, KOORDINATOR, USER).
 */
class UserLevel extends Model
{
    protected $table = 'ms_user_level';

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'is_super', 'urutan', 'active',
    ];

    protected $casts = [
        'is_super' => 'boolean',
        'active'   => 'boolean',
        'urutan'   => 'integer',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(UserLevelPanelAction::class, 'level_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'level_id');
    }
}
