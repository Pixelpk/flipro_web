<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class HomeOwner extends Authenticatable
{
    use HasFactory, HasApiTokens, SearchableTrait;

    protected $searchable = [
        'columns' => [
            'home_owners.name' => 10,
            'home_owners.email' => 10,
            'home_owners.address' => 2,
            'home_owners.phone' => 5,
        ],
    ];

    protected $hidden = [
        'password'
    ];
    
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:home_owners' . ($this->id ? ',' . $this->id : ''),
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required'
        ];
    }
}
