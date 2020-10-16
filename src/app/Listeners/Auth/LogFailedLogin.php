<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogFailedLogin
{
    public function handle(Failed $event)
    {
        Log::channel('security')->info('User failed to log in', [
            'attemptedUserId' => $event->user ? $event->user->getAuthIdentifier() : null,
            'attemptedUsername' => $event->credentials['username'],
            'attemptedPasswordChecksum' => crc32($event->credentials['password'])
        ]);
    }
}
