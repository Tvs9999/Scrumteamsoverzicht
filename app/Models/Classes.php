<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_at',
    ];

    public function user(): HasMany 
    {
        return $this->hasMany(User::class);
    }

    public function workshop(): HasMany 
    {
        return $this->hasMany(Workshop::class);
    }

    public function scrumteams(): HasMany 
    {
        return $this->hasMany(Scrumteam::class, 'class_id');
    }
}
