<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        Log::channel('security')->info('User successfully logged in', [
            'userId' => $event->user->getAuthIdentifier(),
        ]);
    }
}