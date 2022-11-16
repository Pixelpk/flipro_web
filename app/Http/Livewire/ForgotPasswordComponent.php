<?php

namespace App\Http\Livewire;

use App\Mail\ForgotPassword;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ForgotPasswordComponent extends Component
{
    public $email;
    public $otp;
    public $otp_code;
    public $password;

    protected $rules = [
            'email' => 'required|email',
            
        ];

    public function render()
    {
        return view('livewire.forgot-password-component')->layout("layouts.auth");
    }

    public function forgot()
    {
        $this->validate();
        $user = User::where('email', $this->email)->first();
        if(!$user)
        {
            return session()->flash('message', 'User not found.');
        }
        $otp = random_int(100000, 999999);
        Otp::forceCreate([
            'otp' => $otp,
            'email' => $this->email,
            'user_id' => 1,
            'otp_type' => 'reset',
        ]);
        Mail::to($this->email)->send(new ForgotPassword(['email' => $this->email, 'otp' => $otp]));
        $this->otp = 'sent';
    }

    public function verifyotp()
    {
        $this->validate([
            'otp_code' => 'required',
            'password' => 'required|min:6'
        ]);
        $otp = Otp::where('email', $this->email)->where('otp_type', 'reset')->where('otp', $this->otp_code)->first();
        if($otp){
            $user = User::where('email', $this->email)->first();
            $user->password = Hash::make($this->password);
            $user->update();
            if(Auth::attempt([
                'email' => $this->email,
                'password' => $this->password
            ])){
                return redirect("/");
            }
        }
        if(!$otp){
            return session()->flash('message', 'Invalid OTP.');
        }
    }
}
