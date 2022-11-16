<?php

namespace App\Listeners;

use App\Events\EvaluationReviewAdded;
use App\Libs\Firebase\Firebase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEvaluationReviewNotification implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */

    public function handle(EvaluationReviewAdded $event)
    {
        $project = $event->project;
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'project-access';
        if($partTakers){
            foreach($partTakers as $token){
                if(isset($token['fcm'])){
                    $fcm = new Firebase();
                    $fcm->setTitle('Project Closed');
                    $fcm->setBody($project['title']. ' has been closed');
                    $fcm->setData($project);
                    $fcm->setToTokens($token['fcm']);
                    $fcm->send();
                }
            }
        }
    }
}
