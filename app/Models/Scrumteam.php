<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrumteam extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'name',
        'status',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
