<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RegistrationsController extends Controller
{
    public function create(Request $request)
    {
        // if(!$request->user()->hasRole('create-'. $request->user_type)){
        //     return response([
        //         'message' => 'unauthorized',
        //         'data' => null
        //     ], 403);
        // }

        $plainPassword = $request->password;

        $request->validate([
            'company_name' => 'nullable',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required',
            'user_type' => 'required|in:' . config('parttaker.types'),
        ]);

        $request->request->add([
            'password' => \Hash::make($request->password),
            'roles' => json_encode(User::defaultRoles()[$request->user_type])
        ]);

        $user = User::forceCreate($request->only([
            'name', 'email', 'phone_code', 'phone', 'address', 'password', 'user_type', 'company_name'
        ]));

        Mail::to($user)->send(new AccountCreated([
            'name' => $user->name,
            'password' => $plainPassword,
            'email' => $user->email
        ]));

        return response([
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'phone_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            // 'user_type' => 'required|in:' . config('parttaker.types'),
            'avatar' => 'nullable|image'
        ]);

        $user = User::find($request->id);
        $user->update($request->only([
            'name',
            'email',
            'phone_code',
            'phone',
            'address',
            // 'user_type',
        ]));

        if($request->hasFile('avatar')){
            $avatar = Storage::disk('local')->put('/users', $request->avatar);
            $user->avatar = url('/stream/' . $avatar);
            $user->update();
        }

        return [
            'message' => 'success',
            'data' => $user
        ];

    }
}
