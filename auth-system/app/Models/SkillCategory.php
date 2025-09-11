<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\CacheObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
    // protected static function booted()
    // {
    //     static::creating(function ($technology) {
    //         if (empty($technology->slug)) {
    //             $technology->slug = Str::slug($technology->name);
    //         }
    //     });
    // }
    protected static function booted()
    {
        static::creating(function ($skillCategory) {
            if (empty($skillCategory->slug)) {
                $skillCategory->slug = Str::slug($skillCategory->name);
            }
        });
        static::observe(CacheObserver::class);

    }
}
