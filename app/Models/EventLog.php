<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'data' => 'json',
    ];

    public function getProjectIdAttribute($value)
    {
        return (int)$value;
    }

    public function getUserIdAttribute($value)
    {
        return (int)$value;
    }
    public function getStatusAttribute($value)
    {
        return (int)$value;
    }
}

