<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short',
        'content',
        'images',
        'thumbnail',
        'is_enabled',
        'custom_fields',
        'seo_title',
        'seo_text_keys',
        'seo_description',
        'views',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'images' => 'array',
        ];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_enabled', true);
    }

    public function thumbnailUrl(): string
    {
        return !empty($this->thumbnail) ? '/storage/'.$this->thumbnail : '';
    }

    public function dateTime()
    {
        return $this->created_at->locale('uk')->isoFormat("D MMMM Y HH:mm, dddd");
    }
}
