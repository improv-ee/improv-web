<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;

/**
 * @group Users
 *
 * Users are identified by their `username` attribute.
 */
class UserController extends Controller
{
    /**
     * Show User details
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
