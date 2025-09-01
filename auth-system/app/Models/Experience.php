<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;

class Experience extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        // 'user_id',
        'position',
        'company',
        // 'company_url',
        'location',
        'start_date',
        'end_date',
        // 'is_current',
        'responsibilities',
        // 'description',
        // 'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'responsibilities' => 'array',
        'is_current' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
