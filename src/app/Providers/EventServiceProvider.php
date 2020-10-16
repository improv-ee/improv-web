<?php

namespace App\Providers;

use App\Events\Organization\UserJoined;
use App\Events\User\UserInvited;
use App\Listeners\Auth\LogAuthenticated;
use App\Listeners\Auth\LogAuthenticationAttempt;
use App\Listeners\Auth\LogFailedLogin;
use App\Listeners\Auth\LogLockout;
use App\Listeners\Auth\LogPasswordReset;
use App\Listeners\Auth\LogRegisteredUser;
use App\Listeners\Auth\LogSuccessfulLogin;
use App\Listeners\Auth\LogSuccessfulLogout;
use App\Listeners\LogSentNotification;
use App\Listeners\Organization\SendNewJoinerNotification;
use App\Listeners\User\SendInviteEmail;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
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
        UserJoined::class => [
            SendNewJoinerNotification::class
        ],
        UserInvited::class => [
            SendInviteEmail::class
        ],
        NotificationSent::class => [
            LogSentNotification::class
        ],


        // User auth related events
        // https://laravel.com/docs/master/authentication#events

        Registered::class => [
            LogRegisteredUser::class,
            SendEmailVerificationNotification::class
        ],

        Attempting::class => [
            LogAuthenticationAttempt::class,
        ],

        Authenticated::class => [
            LogAuthenticated::class,
        ],

        Login::class => [
            LogSuccessfulLogin::class,
        ],

        Failed::class => [
            LogFailedLogin::class,
        ],

        Logout::class => [
            LogSuccessfulLogout::class,
        ],

        Lockout::class => [
            LogLockout::class,
        ],

        PasswordReset::class => [
            LogPasswordReset::class,
        ],
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
