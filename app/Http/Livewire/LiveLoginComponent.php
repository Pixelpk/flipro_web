<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveLoginComponent extends Component
{
    public $email;
    public $password;
    public $remember;

    protected $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

    public function render()
    {
        return view('livewire.live-login-component')->layout("layouts.auth");
    }

    public function login()
    {
        $this->validate();
        $credentials = [
            'email' => $this->email,'password' => $this->password,'user_type' => 'admin'
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            return redirect()->route('dashboard');
        }
        {
            return redirect("/");
        }
       
        return session()->flash('message', 'Invalid email or password');
       
    }
}