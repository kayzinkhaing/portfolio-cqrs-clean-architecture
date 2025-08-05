<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = ['name', 'township_id'];
    public function township()
    {
        return $this->belongsTo(Township::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
