<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class AuthenticateIfPossible extends Authenticate
{
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        Auth::shouldUse('api');
    }

}
