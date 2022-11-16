<?php

namespace App\Listeners;

use App\Events\ProjectCreated;
use App\Libs\Firebase\Firebase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProjectCreationNotification implements ShouldQueue
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
     * @param  \App\Events\ProjectCreated  $event
     * @return void
     */
    public function handle(ProjectCreated $event)
    {
        $project = $event->project;
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'new-project';
        if($partTakers){
            foreach($partTakers as $token){
                if(isset($token['fcm'])){
                    $fcm = new Firebase();
                    $fcm->setTitle('New Project Added');
                    $fcm->setBody($project['title']);
                    $fcm->setData($project);
                    $fcm->setToTokens($token['fcm']);
                    $fcm->send();
                }
            }
        }
    }
}
