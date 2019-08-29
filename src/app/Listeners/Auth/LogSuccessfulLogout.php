<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogSuccessfulLogout
{
    public function handle(Logout $event)
    {
        Log::channel('security')->info('User successfully logged out', [
            'userId' => $event->user->getAuthIdentifier(),
        ]);
    }
}