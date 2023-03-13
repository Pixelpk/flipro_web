<?php

namespace App\Http\Controllers;

use App\Events\EvaluationAdded;
use App\Events\EvaluationReviewAdded;
use App\Libs\Firebase\Firebase;
use App\Models\EventLog;
use App\Models\Project;
use App\Models\PropertyValue;
use Illuminate\Http\Request;

class ProjectValuesController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'value' => 'required',
            'project_id' => 'required|exists:projects,id'
        ]);

        $propertyValue = PropertyValue::where('project_id', $request->project_id)->first();

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $request->project_id,
            'description' =>  $propertyValue ? $request->user()->name." updated the value to $".number_format((float)$request->value, 2) : $request->user()->name." added $".number_format((float)$request->value, 0). " value",
            'status' => 3,
        ]);


        PropertyValue::forceCreate([
            'user_id' => $request->user()->id,
            'value' => (int)$request->value,
            'project_id' => $request->project_id
        ]);

        $project = Project::find($request->project_id);
        EvaluationAdded::dispatch($project);

        return [
            'message' => 'success',
            'data' => $project,
        ];
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'client_satisfied' => 'required|boolean',
            'client_reviews' => 'required',
            'project_id' => 'required|exists:projects,id',
        ]);

        $value = PropertyValue::where('project_id', $request->project_id)->orderByDesc('id')->first();

        $value->client_satisfied = $request->client_satisfied;
        $value->client_reviews = $request->client_reviews;
        $value->update();
        if($request->client_satisfied)
        {
            EventLog::forceCreate([
                'user_id' => $request->user()->id,
                'project_id' => $request->project_id,
                'description' => $request->user()->name . "close the project and project is moved to close stage",
                'status' => 3,
            ]);
        }

        $project = Project::find($request->project_id);
        EvaluationReviewAdded::dispatch($project);
        if($value->client_satisfied){
            $project->status = 'closed';
            $project->update();
        }

        return [
            'message' => 'success',
            'data' => Project::find($request->project_id)
        ];
    }

    public function notifyEvaluation($project)
    {
        $partTakers = $project->partTakerFcmTokens([request()->user()->id]);
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'project-access';
        if($partTakers){
            foreach($partTakers as $token){
                if(isset($token['token'])){
                    $fcm = new Firebase();
                    $fcm->setTitle('Project evaluated');
                    $fcm->setBody('Your project has been evaluated');
                    $fcm->setData($project);
                    $fcm->setToTokens($token['token']);
                    $fcm->send();
                }
            }
        }
    }

    public function notifyEvaluationReview($project)
    {
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'project-access';
        $approved = request()->client_satisfied ? 'approved' : 'rejected';
        if($partTakers){
            foreach($partTakers as $token){
                if(isset($token['token'])){
                    $fcm = new Firebase();
                    $fcm->setTitle('Project evaluation ' . $approved);
                    $fcm->setBody("Project evaluation is $approved and reviewed by client");
                    $fcm->setData($project);
                    $fcm->setToTokens($token['token']);
                    $fcm->send();
                }
            }
        }
    }
}