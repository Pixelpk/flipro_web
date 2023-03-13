<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProjectIdAttribute($value)
    {
        return (int)$value;
    }

    public function getUserIdAttribute($value)
    {
        return (int)$value;
    }

    public function getPrivateAttribute($value)
    {
        // return (int)$value;
        return $value == 1 ? true : false;
    }
}
