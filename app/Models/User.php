<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SearchableTrait;

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.email' => 10,
            'users.address' => 2,
            'users.phone' => 5,
        ],
    ];

    protected $appends = [
        // 'abilities'
    ];

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users' . ($this->id ? ',' . $this->id : ''),
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_code',
        'phone',
        'address',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAbilitiesAttribute()
    {
        return explode(',', $this->roles);
    }

    public function hasRole($role)
    {
        if (in_array('administrator', $this->abilities)) {
            return true;
        }

        if (in_array($role, $this->abilities)) {
            return true;
        }

        return false;
    }

    public static function defaultRoles()
    {
        return [
            'franchise' => [
                'view-projects',
                'create-projects',
                'update-projects',
                'delete-projects',
            ],
            'builder' => [

            ],
            'home-owner' => [

            ],
            'evaluator' => [

            ],
            'admin' => [

            ]
        ];
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public static function franchises()
    {
        return User::where('user_type', 'franchise')->when(!Auth::user()->hasRole('administrator'), function($q){
            return $q->where('created_by', Auth::id());
        });
    }

    public static function homeowners()
    {
        return User::where('user_type', 'home-owner')->when(!Auth::user()->hasRole('administrator'), function($q){
            return $q->where('created_by', Auth::id());
        });
    }

    public static function builders()
    {
        return User::where('user_type', 'builder')->when(!Auth::user()->hasRole('administrator'), function($q){
            return $q->where('created_by', Auth::id());
        });
    }

    public static function evaluators()
    {
        return User::where('user_type', 'evaluator')->when(!Auth::user()->hasRole('administrator'), function($q){
            return $q->where('created_by', Auth::id());
        });
    }

    public function getEmailSettingsAttribute()
    {
        return UserSmtp::where('user_id', Auth::id())->first();
    }
}
