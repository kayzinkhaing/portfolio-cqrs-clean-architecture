<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class BlogReadModel extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'blogs';

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'excerpt',
        'content',
        'published_at',
        'created_at',
        'updated_at',
    ];
}
