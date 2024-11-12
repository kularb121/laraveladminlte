<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class, // Add this line
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