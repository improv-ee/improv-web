<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogAuthenticated
{
    public function handle(Authenticated $event)
    {
        Log::channel('security')->info('User authenticated', [
            'userId' => $event->user->getAuthIdentifier(),
        ]);
    }
}