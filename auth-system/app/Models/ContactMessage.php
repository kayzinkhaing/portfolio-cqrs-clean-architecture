<?php

namespace App\Models;

use App\Observers\CacheObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ContactMessageObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
    protected static function booted()
    {
        static::observe(CacheObserver::class);
    }
    // protected static function booted()
    // {
    //     ContactMessage::observe(ContactMessageObserver::class);
    // }
}
