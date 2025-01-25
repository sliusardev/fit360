<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'specialization',
        'avatar',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_trainer');
    }

    public function activitiesOld(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_trainer')->old();
    }

    public function activitiesNotStarted(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_trainer')->notStarted();
    }

    public function getImageUrl(): string
    {
        return !empty($this->avatar) ? '/storage/'.$this->avatar : '';
    }
}
