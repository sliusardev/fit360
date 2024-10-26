<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_enabled',
        'image',
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

    public function getImageUrl(): string
    {
        return !empty($this->image) ? '/storage/'.$this->image : '';
    }
}
