<?php

namespace App\Listeners;

use App\Events\ProgressAdded;
use App\Libs\Firebase\Firebase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProgressNotification implements ShouldQueue
{
    // public $connection = 'database';
  	// public $queue = 'listeners';
  	// public $delay = '1';

    public function __construct()
    {

    }


    public function handle(ProgressAdded $event)
    {
        $project = $event->project;
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'progress';
        if($partTakers){
            foreach($partTakers as $token){
                $fcm = new Firebase();
                $fcm->setTitle('New Progress Submitted');
                $fcm->setBody('Progress submitted on '. $project['title']);
                $fcm->setData($project);
                $fcm->setToTokens($token['fcm']);
                $fcm->send();

                if($token['user_type'] == 'home-owner' && $project['status'] == 'complete'){
                    $project['notification_type'] = 'review-required';
                    $fcm->setTitle('Progress review required');
                    $fcm->setBody('Project progress waiting for your review');
                    $fcm->setData($project);
                    $fcm->setToTokens($token['fcm']);
                    $fcm->send();
                }
            }
        }
    }
}
