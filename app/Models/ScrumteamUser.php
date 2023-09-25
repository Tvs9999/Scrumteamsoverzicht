<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScrumteamUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'scrumteam_id',
        'user_id',
    ];

    public function class(): BelongsTo 
    {
        return $this->belongsTo(Scrumteam::class);
    }

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}
