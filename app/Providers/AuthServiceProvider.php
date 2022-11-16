<?php

namespace App\Providers;

use App\Policies\LeadPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Lead' => 'App\Policies\LeadPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('create-user', [UserPolicy::class, 'create']);
        // Gate::define('update-user', [UserPolicy::class, 'update']);
        // Gate::define('delete-user', [UserPolicy::class, 'delete']);
        // Gate::define('force-user', [UserPolicy::class, 'forceDelete']);
        // Gate::define('restore-user', [UserPolicy::class, 'restore']);
        // Gate::define('administrate', [UserPolicy::class, 'administrate']);
        // Gate::define('create-admin', [UserPolicy::class, 'createAdmin']);
        // Gate::define('create-franchise', [UserPolicy::class, 'createFranchise']);
        // Gate::define('create-evaluator', [UserPolicy::class, 'createEvaluator']);
        // Gate::define('create-home-owner', [UserPolicy::class, 'createHomeOwner']);
        // Gate::define('create-builder', [UserPolicy::class, 'createBuilder']);
        // Gate::define('view-any-leads', [UserPolicy::class, 'viewAny']);
        // Gate::define('view-leads', [UserPolicy::class, 'view']);
        // Gate::define('create-leads', [UserPolicy::class, 'create']);
        Gate::define('delete-lead', [LeadPolicy::class, 'delete']);
        Gate::define('update-lead', [LeadPolicy::class, 'delete']);
    }
}
