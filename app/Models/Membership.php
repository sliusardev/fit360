<?php

namespace App\Models;

use App\Enums\MembershipsAccessTypeEnum;
use App\Enums\MembershipsDurationTypeEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

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
}
