<?php

namespace App\Providers;

use App\Events\EvaluationAdded;
use App\Events\EvaluationReviewAdded;
use App\Events\ProgressAdded;
use App\Events\ProjectApproved;
use App\Events\ProjectCreated;
use App\Events\ProjectRejected;
use App\Events\RoleAssigned;
use App\Listeners\SendEvaluationNotification;
use App\Listeners\SendEvaluationReviewNotification;
use App\Listeners\SendProgressNotification;
use App\Listeners\SendProjectApprovedNotification;
use App\Listeners\SendProjectCreationNotification;
use App\Listeners\SendProjectRejectedNotification;
use App\Listeners\SendRoleAssignedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProjectCreated::class => [
            SendProjectCreationNotification::class
        ],
        ProjectApproved::class => [
            SendProjectApprovedNotification::class
        ],
        ProjectRejected::class => [
            SendProjectRejectedNotification::class
        ],
        ProgressAdded::class => [
            SendProgressNotification::class
        ],
        EvaluationAdded::class => [
            SendEvaluationNotification::class
        ],
        EvaluationReviewAdded::class => [
            SendEvaluationReviewNotification::class
        ],
        RoleAssigned::class => [
            SendRoleAssignedNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}
