<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;

class TimelineItem extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'type',
        'start_date',
        'end_date',
        'year',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
