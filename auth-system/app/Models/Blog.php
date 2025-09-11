<?php

namespace App\Models;

use App\Observers\CacheObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = ['user_id', 'title', 'excerpt', 'content', 'published_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::observe(CacheObserver::class);
    }
}
