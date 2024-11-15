<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Asset;
use App\Models\Workflow;
use App\Policies\UserPolicy;
use App\Policies\AssetPolicy;
use App\Policies\WorkflowPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

        Asset::class => AssetPolicy::class,
        User::class => UserPolicy::class, // Add this line
        Workflow::class => WorkflowPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-users', function (User $user) {
            return $user->role && $user->role->name === 'Administrator';
        });

        Gate::define('edit-user-roles', function (User $user) {
            return $user->role && $user->role->name === 'Administrator';
        });

        Gate::define('editRole', function (User $user) {
            return $user->role && $user->hasRole('Administrator'); // Or any other role allowed to edit roles
        });
    }
}