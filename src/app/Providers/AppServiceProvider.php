<?php

namespace App\Providers;

use App\Observers\EventObserver;
use App\Observers\OrganizationObserver;
use App\Observers\ProductionObserver;
use App\Orm\Event;
use App\Orm\Organization;
use App\Orm\Production;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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

        // Bind observers
        // If this section grows too big, refactor into a dedicated service provider
        Production::observe(ProductionObserver::class);
        Event::observe(EventObserver::class);
        Organization::observe(OrganizationObserver::class);
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
