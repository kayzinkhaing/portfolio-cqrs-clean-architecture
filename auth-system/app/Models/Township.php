<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    protected $fillable = ['name'];
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
