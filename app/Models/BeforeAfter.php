<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BeforeAfter extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_before',
        'image_after',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_enabled', true);
    }

    public function getBeforeImageUrl(): string
    {
        return !empty($this->image_before) ? '/storage/'.$this->image_before : '';
    }

    public function getAfterImageUrl(): string
    {
        return !empty($this->image_after) ? '/storage/'.$this->image_after : '';
    }
}
