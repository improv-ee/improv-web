<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;

/**
 * @package App\Listeners
 */
class LogLockout
{
    public function handle(Lockout $event)
    {
        Log::channel('security')->info('User locked out', [
            'username' => $event->request->input('username'),
        ]);
    }
}