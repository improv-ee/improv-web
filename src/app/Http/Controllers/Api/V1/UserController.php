<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\User\UserInvited;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserInviteRequest;
use App\Http\Resources\V1\UserResource;
use App\Orm\Invite;
use App\User;
use Clarkeash\Doorman\Facades\Doorman;

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

    /**
     * Send an invitation to join the platform to an e-mail address
     *
     * @bodyParam email string required To whom to send the invitation to
     *
     * @param UserInviteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(UserInviteRequest $request)
    {
        $invite = Doorman::generate()
            ->expiresIn(14)
            ->for($request->input('email'))
            ->make()
            ->first();

        // "Converting" to an overwritten instance of Invite (vendor package does not support overwriting)
        // Need to use custom model in order to serialize it
        $invite = Invite::findOrFail($invite->id);

        event(new UserInvited($invite, $request->user()));
        return response()->json();
    }
}
