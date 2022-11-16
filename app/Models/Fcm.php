<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fcm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'active'
    ];

    public static function adminFCMs()
    {
        return User::join('fcms', 'fcms.user_id', 'users.id')->where('users.user_type', 'admin')->select('fcms.*')->get()->toArray();
    }
    public static function franFCMs()
    {
        return User::join('fcms', 'fcms.user_id', 'users.id')->where('users.user_type', 'franchise')->select('fcms.*')->get()->toArray();
    }
}
