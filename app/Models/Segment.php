<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    public function scopeOwned($tag)
    {
        $tag->where('user_id', request()->user()->id);
    }
}
