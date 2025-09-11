<?php

namespace App\Models;

use App\Traits\HasImages;
use App\Observers\CacheObserver;
use App\Observers\EducationObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    protected $table = 'educations';
    use HasFactory, HasImages;

    protected $fillable = [
        'institution',
        'degree',
        'location',
        'start_date',
        'end_date',
        // 'is_current',
        'details',
        // 'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];
    protected static function booted()
    {
        static::observe(CacheObserver::class);
    }

    // protected static function booted()
    // {
    //     Education::observe(EducationObserver::class);
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

