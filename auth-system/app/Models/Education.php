<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
