<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Firebase\Firebase;
use App\Models\EventLog;
use App\Models\Progress;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectReviewsController extends Controller
{
    public function addReview(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_satisfied' => 'boolean|required',
            'client_reviews' => 'required'
        ]);

        $progress = Progress::where('project_id', $request->project_id)
        ->where('final_progress', true)
        ->orderByDesc('id')
        ->first();

        $project = Project::find($request->project_id);

        if(!$progress) {
            return response([
                'message' => 'Project is in progress status',
                'data' => null
            ], 403);
        }

      	//dd($progress);

        $progress->client_satisfied = $request->client_satisfied;
        $progress->client_reviews = $request->client_reviews;
        $progress->update();

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $request->project_id,
            'description' => $request->client_satisfied ? $request->user()->name. " added progress satisfaction review (Satisfied)" :  $request->user()->name.' added progress satisfaction review (Not satisfied)',
            'status' => 3,
        ]);
        if(!$request->client_satisfied){
            $project->status = 'in-progress';
            $project->update();
            EventLog::forceCreate([
                'user_id' => $request->user()->id,
                'project_id' => $request->project_id,
                'description' => $request->user()->name. " is not satisfied with progress - project is moved to in-progress",

                'status' => 2,
            ]);
        }

        return [
            'message' => 'success',
            'data' => $project
        ];

    }

    public function notify($project)
    {
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'project-access';
        $approved = request()->client_satisfied ? 'approved' : 'rejected';
        if($partTakers){
            foreach($partTakers as $token){
                $fcm = new Firebase();
                $fcm->setTitle('Final progress ' . $approved);
                $fcm->setBody("Final progress is $approved and reviewed by client");
                $fcm->setData($project);
                $fcm->setToTokens($token['token']);
                $fcm->send();
            }
        }
    }
}
