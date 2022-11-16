<?php

namespace App\Listeners;

use App\Events\RoleAssigned;
use App\Libs\Firebase\Firebase;
use App\Models\Fcm;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRoleAssignedNotification implements ShouldQueue
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
     * @param  \App\Events\RoleAssigned  $event
     * @return void
     */
    public function handle(RoleAssigned $event)
    {
        $project = $event->project;
        $user = $event->user;
        $partTakers = Fcm::where('user_id', $user->id)->get();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'project-access';
        if($partTakers){
            foreach($partTakers as $token){
                $fcm = new Firebase();
                $fcm->setTitle('Project Assigned');
                $fcm->setBody('You are assigned to '. $project['title']);
                $fcm->setData($project);
                $fcm->setToTokens($token['token']);
                $fcm->send();
            }
        }
    }
}
