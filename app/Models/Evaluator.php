<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Evaluator extends Authenticatable
{
    use HasFactory, HasApiTokens, SearchableTrait;

    protected $searchable = [
        'columns' => [
            'evaluators.name' => 10,
            'evaluators.email' => 10,
            'evaluators.address' => 2,
            'evaluators.phone' => 5,
        ],
    ];

    protected $hidden = [
        'password'
    ];
    
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:evaluators' . ($this->id ? ',' . $this->id : ''),
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required'
        ];
    }
}
