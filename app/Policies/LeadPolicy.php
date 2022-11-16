<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LeadPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Lead $model)
    {
        if($user->hasRole('administrator')) return Response::allow();
        
        if($user->id == $model->user_id){
            return Response::allow();
        }

        return Response::deny();
    }

    public function update(User $user, Lead $model)
    {
        if($user->hasRole('administrator')) return Response::allow();
        
        if($user->id == $model->user_id){
            return Response::allow();
        }

        return Response::deny();
    }
}
