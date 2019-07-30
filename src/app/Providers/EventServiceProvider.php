<?php

namespace App\Providers;

use App\Events\Organization\UserJoined;
use App\Events\User\UserInvited;
use App\Listeners\LogSentNotification;
use App\Listeners\Organization\SendNewJoinerNotification;
use App\Listeners\User\SendInviteEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Notifications\Events\NotificationSent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            //SendEmailVerificationNotification::class, // Temporarily disabled until invitation codes are turned off
        ],
        UserJoined::class => [
            SendNewJoinerNotification::class
        ],
        UserInvited::class => [
            SendInviteEmail::class
        ],
        NotificationSent::class => [
            LogSentNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }
}
