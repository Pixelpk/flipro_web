<?php

namespace App\Http\Controllers\Api;

use App\Events\RoleAssigned;
use App\Http\Controllers\Controller;
use App\Libs\Firebase\Firebase;
use App\Models\EventLog;
use App\Models\Fcm;
use App\Models\Project;
use App\Models\ProjectAccess;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectRolesController extends Controller
{
    public function get(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required'
        ]);

        return response([
            'message' => 'success',
            'data' => ProjectAccess::where('project_id', $request->project_id)->where('user_id', $request->user_id)->first()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required',
        ]);

        $user = User::find($request->user_id);

        $allRoles = config('roles.projectRoles');
        $roles = ProjectAccess::where('project_id', $request->project_id)->where('user_id', $request->user_id)->first();


        $result = [];
        
        $requestedRoles = json_decode($request->roles, true);
        foreach($allRoles as $role){
            if(($role == 'review_progress' || $role == 'review_evaluation') &&  $user->user_type == 'home-owner'){
                $result[$role] = true;

            } else {
                $result[$role] = isset($requestedRoles[$role]) ? $requestedRoles[$role] : false;
            }
            if($role == 'view' && (isset($requestedRoles[$role]) ? $requestedRoles[$role] : false)){
                RoleAssigned::dispatch(Project::find($request->project_id), User::find($request->user_id));
                // $this->notify(Project::find($request->project_id), $request->user());
            }
        }

        if($roles) 
        {
            $roles->roles = $result;
            $roles->update();
        } 
        else
         {
            ProjectAccess::forceCreate([
                'project_id' => $request->project_id,
                'roles' => $result,
                'user_id' => $request->user_id,
                'acting_as' => $user->user_type
            ]);
        }

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $request->project_id,
            'description' =>  $roles ? $request->user()->name." edit the access of $user->name" : $request->user()->name." assigned $user->name to project",
            'status' => 6,
            'data' => $roles ? $roles :  null
        ]);

        return [
            'message' => 'success',
            'data' => Project::find($request->project_id)
        ];

    }

    public function notify($project, $user)
    {
        $partTakers = Fcm::where('user_id', $user->id)->get();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'project-access';
        if($partTakers){
            foreach($partTakers as $token){
                $fcm = new Firebase();
                $fcm->setTitle('Project assigned');
                $fcm->setBody('You are assigned to a new project');
                $fcm->setData($project);
                $fcm->setToTokens($token['token']);
                $fcm->send();
            }
        }
    }
}
