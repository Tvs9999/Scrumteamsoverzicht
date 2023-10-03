<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'user_id',
        'name',
        'description',
        'date',
        'duration',
        'min_pers',
        'max_pers',
        'location',
    ];



    public function class(): BelongsTo 
    {
        return $this->belongsTo(Classes::class);
    }

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
