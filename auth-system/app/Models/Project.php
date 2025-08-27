<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Support\Str;
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

    // relationships
    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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


    // images available via HasImages trait ($project->images(), $project->primaryImage())
}
