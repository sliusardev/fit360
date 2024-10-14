<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'description',
        'start_time',
        'duration_minutes',
        'available_slots',
        'room',
        'price',
        'discount',
        'image'
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime'
        ];
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

}
