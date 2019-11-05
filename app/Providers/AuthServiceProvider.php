<?php

namespace App\Providers;

use Gate;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user) {
            return $user->hasRole(config('access.users.admin_role')) ? true : null;
        });
        Passport::routes();
        Passport::personalAccessTokensExpireIn(now()->addSeconds(15000));
        Passport::tokensExpireIn(now()->addSeconds(15000));
        Passport::refreshTokensExpireIn(now()->addSeconds(36000));
    }
}
