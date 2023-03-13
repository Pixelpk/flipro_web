<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

  	protected $guarded = [];
    protected $casts = [
        'videos' => 'array',
        'photos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function getFinalProgressAttribute($value)
    {
        return (int)$value;
    }

    public function getProjectIdAttribute($value)
    {
        return (int)$value;
    }

    public function getUserIdAttribute($value)
    {
        return (int)$value;
    }
}
