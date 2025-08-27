<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;

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
        return $this->belongsToMany(Project::class, 'project_technology');
    }
}
