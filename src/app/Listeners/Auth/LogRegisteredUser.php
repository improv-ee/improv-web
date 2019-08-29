<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogRegisteredUser
{
    public function handle(Registered $event)
    {
        Log::channel('security')->info('User registered', [
            'userId' => $event->user->getAuthIdentifier(),
        ]);
    }
}