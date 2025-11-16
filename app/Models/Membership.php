<?php

namespace App\Models;

use App\Enums\MembershipsAccessTypeEnum;
use App\Enums\MembershipsDurationTypeEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Membership extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'access_type',
        'duration_type',
        'duration_days',
        'visit_limit',
        'price',
        'is_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'access_type' => MembershipsAccessTypeEnum::class,
        'duration_type' => MembershipsDurationTypeEnum::class,
        'is_enabled' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('start_date', 'end_date', 'visit_limit', 'is_enabled')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_enabled', true);
    }

    public function getAccessTypeLabel(): string
    {
        return match($this->access_type) {
            MembershipsAccessTypeEnum::GYM => 'Тренажерний зал',
            MembershipsAccessTypeEnum::GROUP => 'Групові заняття',
            MembershipsAccessTypeEnum::ALL => 'Повний доступ',
            default => 'Не визначено',
        };
    }

    public function getDurationTypeLabel(): string
    {
        return match($this->duration_type) {
            MembershipsDurationTypeEnum::UNLIMITED => 'Необмежений',
            MembershipsDurationTypeEnum::VISITS => 'За відвідуваннями',
            default => 'Не визначено',
        };
    }

    public function getDurationLabel(): string
    {
        if ($this->duration_type === MembershipsDurationTypeEnum::VISITS) {
            return $this->visit_limit . ' відвідувань';
        }
        return $this->duration_days . ' днів';
    }

    public function payments(): morphMany
    {
        return $this->morphMany(Payment::class, 'payable')->with('user');
    }

    public function isUserActiveMembership(User $user): bool
    {
        return $this->users()
            ->where('user_id', $user->id)
            ->wherePivot('is_enabled', true)
            ->wherePivot('end_date', '>=', now())
            ->exists();
    }
}
