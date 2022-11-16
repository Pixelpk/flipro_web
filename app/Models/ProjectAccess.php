<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAccess extends Model
{
    use HasFactory;
    
    protected $appends = ['user'];

    protected $casts = [
        'roles' => 'array'
    ];


    public function getUserAttribute()
    {
        return User::find($this->user_id);
    }
}
