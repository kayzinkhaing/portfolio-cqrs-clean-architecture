<?php

namespace App\Models;

use App\Traits\HasImages;
use App\Observers\CacheObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        // 'user_id',
        'position',
        'company',
        // 'company_url',
        'location',
        'start_date',
        'end_date',
        // 'is_current',
        'responsibilities',
        // 'description',
        // 'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'responsibilities' => 'array',
        'is_current' => 'boolean',
    ];
    protected static function booted()
    {
        static::observe(CacheObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
