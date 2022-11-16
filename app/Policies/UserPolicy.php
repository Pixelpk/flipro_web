<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $model)
    {
        return Response::allow();
    }

    public function update(User $user, User $model)
    {
        if($user->user_type == 'admin'){
            return Response::allow();
        }
        if($user->id != $model->id){
            return Response::deny();
        }
    }

}
