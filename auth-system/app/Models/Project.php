<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Support\Str;
use App\Observers\CacheObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes, HasImages;

    protected $fillable = [
        // 'user_id',
        'title',
        'slug',
        // 'summary',
        'description',
        // 'website_url',
        // 'github_url',
        // 'meta',
        'status_id',
        'start_date',
        'end_date',
        // 'is_published',
        'is_featured',
        // 'sort_order',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function technologies()
    {
        return $this->belongsToMany(Technology::class)
            ->withTimestamps(); // ensures pivot created_at / updated_at available
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
    protected static function booted()
    {
        static::observe(CacheObserver::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    // relationships
    // public function technologies()
    // {
    //     return $this->belongsToMany(Technology::class, 'project_technology');
    // }

    // public function technologies()
    // {
    //     return $this->belongsToMany(
    //         Technology::class,
    //         'project_technology'
    //     )->using(ProjectTechnology::class)
    //     ->withPivot('project_id', 'technology_id', 'created_at', 'updated_at') // add pivot fields
    //     ->withTimestamps();
    // }




    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }



    // images available via HasImages trait ($project->images(), $project->primaryImage())
}
