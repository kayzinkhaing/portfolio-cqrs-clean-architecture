<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];
    protected static function booted()
    {
        static::creating(function ($status) {
            $status->slug = Str::slug($status->name);
        });

        static::updating(function ($status) {
            $status->slug = Str::slug($status->name);
        });
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
