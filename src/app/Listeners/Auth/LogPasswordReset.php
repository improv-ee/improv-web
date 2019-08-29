<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogPasswordReset
{
    public function handle(PasswordReset $event)
    {
        Log::channel('security')->info('Reset the password for user', [
            'userId' => $event->user->getAuthIdentifier(),
        ]);
    }
}