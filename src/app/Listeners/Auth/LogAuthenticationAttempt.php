<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogAuthenticationAttempt
{
    public function handle(Attempting $event)
    {
        Log::channel('security')->info('Attempting user authentication', [
            'username' => $event->credentials['username'],
            'passwordChecksum' => crc32($event->credentials['password'])
        ]);
    }
}