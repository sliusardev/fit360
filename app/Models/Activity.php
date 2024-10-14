<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'location',
        'description',
        'start_time',
        'duration_minutes',
        'available_slots',
        'room',
        'price',
        'discount',
        'image',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'is_enabled' => 'boolean',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'activity_user');
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(Trainer::class, 'activity_trainer');
    }

    public function scopeNotStarted(Builder $query): void
    {
        $query->where('start_time', '>=', now());
    }

    public function scopeOld(Builder $query): void
    {
        $query->where('start_time', '<', now());
    }

    public function getFreeSlots()
    {
        $clients = $this->users()->count();

        return $this->available_slots - $clients;
    }

    public function isOld(): bool
    {
        return $this->start_time < now();
    }

    public function getImageUrl(): string
    {
        return !empty($this->image) ? '/storage/'.$this->image : '';
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_enabled', true)
            ->where('created_at', '<=',Carbon::now());
    }

}
