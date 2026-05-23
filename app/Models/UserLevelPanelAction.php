<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Pivot 3-way: level × panel × action + scope.
 * Row mendefinisikan "level X bisa lakukan action Y pada panel Z dengan scope S".
 */
class UserLevelPanelAction extends Model
{
    protected $table = 'ms_user_level_panel_action';

    protected $fillable = [
        'level_id', 'panel_id', 'action_id', 'scope', 'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public const SCOPES = ['all', 'own', 'participant', 'division', 'none'];

    public function level(): BelongsTo    { return $this->belongsTo(UserLevel::class, 'level_id'); }
    public function panel(): BelongsTo    { return $this->belongsTo(Panel::class, 'panel_id'); }
    public function action(): BelongsTo   { return $this->belongsTo(Action::class, 'action_id'); }
}
