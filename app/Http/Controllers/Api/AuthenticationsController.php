<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Builder;
use App\Models\Evaluator;
use App\Models\Fcm;
use App\Models\Franchise;
use App\Models\HomeOwner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationsController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'app' => 'required|in:admin,franchise,tradesmen'
        ]);

        $user = Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(!$user) {
            return response([
                'message' => 'Invalid email address or password',
                'data' => []
            ], 401);
        }


        $user = User::where('email', $request->email)->first();

        // if($request->app == 'tradesmen' && ($user->user_type != 'builder' || $user->user_type != 'evaluator' || $user->user_type != 'home-owner'))
        // {
        //     return response([
        //         'message' => 'Please login into your respected app '.$user->user_type,
        //         'data' => []
        //     ], 300);
        // }

        if($request->app == 'franchise' && $user->user_type != 'franchise')
        {
            return response([
                'message' => 'Please login into your respected app '.$user->user_type,
                'data' => []
            ], 300);
        }

        elseif($request->app == 'admin' && $user->user_type != 'admin')
        {
            return response([
                'message' => 'Please login into your respected app '.$user->user_type,
                'data' => []
            ], 300);
        }

        $fcm = Fcm::where('user_id', $user->id)->first();
        if($fcm && $request->fcm){
            $fcm->token = $request->fcm;
            $fcm->update();
        }
        else{
            $fcm = Fcm::firstOrCreate([
                'user_id' => $user->id,
                'token' => $request->fcm,
            ]);
            $fcm->active = true;
            $fcm->update();
        }

        return response([
            'message' => 'Logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('app')->plainTextToken
            ]
        ]);

    }
}
