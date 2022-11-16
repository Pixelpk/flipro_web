<?php

namespace App\Listeners;

use App\Events\EvaluationAdded;
use App\Libs\Firebase\Firebase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEvaluationNotification implements ShouldQueue
{
    // public $connection = 'database';
  	// public $queue = 'listeners';
  	// public $delay = '1';

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EvaluationAdded  $event
     * @return void
     */
    public function handle(EvaluationAdded $event)
    {
        $project = $event->project;
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'project-access';
        if($partTakers){
            foreach($partTakers as $token){
                if(isset($token['fcm'])){
                    $fcm = new Firebase();
                    $fcm->setTitle('Project Evaluated');
                    $fcm->setBody($project['title']. ' has been evaluated');
                    $fcm->setData($project);
                    $fcm->setToTokens($token['fcm']);
                    $fcm->send();
                }
            }
        }
    }
}
