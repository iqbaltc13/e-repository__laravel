<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Journal;
use App\Policies\JournalPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Journal::class => JournalPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Gates untuk role-based access
        Gate::define('manage-users', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manage-categories', function ($user) {
            return $user->isAdmin() || $user->isEditor();
        });

        Gate::define('view-all-journals', function ($user) {
            return $user->isAdmin() || $user->isEditor();
        });
    }
}
