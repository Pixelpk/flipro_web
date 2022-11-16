<?php

namespace App\Listeners;

use App\Events\ProjectApproved;
use App\Libs\Firebase\Firebase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProjectApprovedNotification implements ShouldQueue
{
  	// public $connection = 'database';
  	// public $queue = 'listeners';
  	// public $delay = '1';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProjectApproved  $event
     * @return void
     */
    public function handle(ProjectApproved $event)
    {
        $project = $event->project;
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'new-project';
        if($partTakers){
            foreach($partTakers as $token){
                if(isset($token['fcm'])){
                    $fcm = new Firebase();
                    $fcm->setTitle('Project ' . $project['approved']);
                    $fcm->setBody($project['title']. ' has been ' . $project['approved']);
                    $fcm->setData($project);
                    $fcm->setToTokens($token['fcm']);
                    $fcm->send();
                }
            }
        }
    }
}
