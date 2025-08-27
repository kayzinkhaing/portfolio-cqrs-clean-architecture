<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technology extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_technology')
                    ->using(ProjectTechnology::class)
                    ->withTimestamps();
    }

    protected static function booted()
    {
        static::creating(function ($technology) {
            if (empty($technology->slug)) {
                $technology->slug = Str::slug($technology->name);
            }
        });
    }

}
