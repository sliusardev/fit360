<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipUser extends Model
{
    use HasFactory;

    protected $table = 'membership_user';

    protected $fillable = [
        'user_id',
        'membership_id',
        'start_date',
        'end_date',
        'visit_limit',
        'is_enabled',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function getIsActiveAttribute(): bool
    {
        if (!$this->is_enabled) {
            return false;
        }

        if (!$this->end_date) {
            return true;
        }

        return $this->end_date->isFuture() || $this->end_date->isToday();
    }
}
