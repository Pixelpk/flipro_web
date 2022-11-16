<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class MatchOldPassword implements Rule
{
    public function __construct()
    {
        # code...
    }
    
    public function passes($attribute, $value)
    {
        return Hash::check($value, auth()->user()->password);
    }
   
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute dose not match with old password.';
    }
}
