<?php

namespace App\Providers;

use App\Orm\Organization;
use App\Policies\OrganizationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Organization::class => OrganizationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes(function ($router) {
            $router->forPersonalAccessTokens();
        });

        if (env('OAUTH_KEY_PATH', false)) {
            Passport::loadKeysFrom(env('OAUTH_KEY_PATH'));
        }
        Passport::tokensExpireIn(now()->addDays(7));
    }
}
