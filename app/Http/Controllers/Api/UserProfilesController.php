<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\Otp;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDO;

class UserProfilesController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'avatar' => 'nullable|image'
        ]);

        if($request->avatar){
            $uploadedavatar = Storage::disk('local')->put('avatars', $request->file('avatar'));
            $avatarUrl = url('/stream/' . $uploadedavatar);
            $request->user()->update(['avatar' => $avatarUrl]);
        }

        $request->user()->update($request->only('name', 'phone_code', 'phone', 'address'));

        return [
            'message' => 'success',
            'data' => User::find($request->user()->id)
        ];
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => 'required'
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return [
            'message' => 'success',
            'data' => null
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'success',
            'data' => null
        ];
    }

    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::firstWhere('email', $request->email);

        
        if($user){
            Otp::where(['user_id' => $user->id, 'otp_type' => 'password-reset'])->delete();
            $otp = rand(100000, 999999);

            Otp::forceCreate([
                'email' => $request->email,
                'user_id' => $user->id,
                'otp_type' => 'password-reset',
                'otp' => $otp
            ]);

            Mail::to($user)->send(new PasswordReset($otp));
        }

        return [
            'message' => 'success',
            'data' => 'null'
        ];
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required'
        ]);

        $otp = Otp::firstWhere(['email' => $request->email, 'otp' => $request->otp]);

        if(!$otp) return response([
            'message' => "Incorrect otp",
            'data' => null
        ], 403);

        if($otp){
            $user = User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            $otp->delete();

            return [
                'message' => 'success', 
                'data' => null
            ];
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email'
        ]);

        $otp = Otp::firstWhere([
            'email' => $request->email,
            'otp' => $request->otp,
        ]);

        if($otp) return [
            'message' => 'success',
            'data' => 'null'
        ];

        return response([
            'message' => 'error',
            'data' => 'null'
        ], 403);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response([
            'message' => 'Profile found',
            'data' => $user,
        ]);
    }
}
