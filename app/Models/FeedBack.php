<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedBack extends Model
{
    protected $fillable = [
        'user_id',
        'text',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->role(RoleEnum::CLIENT);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_enabled', true);
    }
}
