<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Franchise extends Authenticatable
{
    use HasFactory, HasApiTokens, SearchableTrait;

    protected $searchable = [
        'columns' => [
            'franchises.name' => 10,
            'franchises.email' => 10,
            'franchises.address' => 2,
            'franchises.phone' => 5,
        ],
    ];

    protected $hidden = [
        'password'
    ];
    
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:franhises' . ($this->id ? ',' . $this->id : ''),
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required'
        ];
    }
}
