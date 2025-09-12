<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'path',
        'alt',
        'type',         // 'image' or 'video'
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the owning model (Project, User, Post, etc.)
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get full URL of media file
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Scope only images
     */
    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    /**
     * Scope only videos
     */
    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    /**
     * Scope primary media
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
}
