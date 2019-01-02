<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // There is a TLS-terminating proxy in front of us.
        // Force laravel to accept the fact and generate HTTPS links
        URL::forceScheme('https');
        $this->app['request']->server->set('HTTPS', 'on');

        Schema::defaultStringLength(191);

        View::share('vueConfig', [
            'organization' => ['roles' => [
                'ROLE_ADMIN' => 0
            ]
            ],
            'apiUrl' => sprintf('https://%s/v1', env('API_DOMAIN')),
            'username' => Auth::user()->username ?? null]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
