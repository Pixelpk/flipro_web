<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Builder extends Authenticatable
{
    use HasFactory, HasApiTokens, SearchableTrait;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'builders.name' => 10,
            'builders.email' => 10,
            'builders.address' => 2,
            'builders.phone' => 5,
        ],
    ];

    protected $hidden = [
        'password'
    ];

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:builders' . ($this->id ? ',' . $this->id : ''),
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required'
        ];
    }
}
