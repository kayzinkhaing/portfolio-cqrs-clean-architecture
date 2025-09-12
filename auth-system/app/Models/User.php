<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\ResetPasswordNotification;
use App\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'township_id',
        'ward_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationships
     */
    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    /**
     * Polymorphic relation: A user can have many images
     */
    public function images()
    {
        return $this->morphMany(Media::class, 'imageable');
    }

    /**
     * Get the user's primary profile image
     */
    public function profileImage()
    {
        return $this->morphOne(Media::class, 'imageable')->where('is_primary', true);
    }

    /**
     * Send the password reset notification
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Fire an event after user is created
     */
    protected static function booted()
    {
        static::created(function ($user) {
            event(new \App\Events\UserCreatedEvent($user));
        });
    }
}
