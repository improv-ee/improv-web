<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\User\UserInvited;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserInviteRequest;
use App\Http\Resources\V1\User\SearchResultResource;
use App\Http\Resources\V1\UserResource;
use App\Orm\Invite;
use App\User;
use Illuminate\Http\Request;
use Clarkeash\Doorman\Facades\Doorman;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

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
     * Search for a User
     *
     * This is meant to be used for autocomplete search operations, where another user needs to be selected
     *
     * If the search input is empty, a random (first) set of users is returned.
     * @param Request $request
     * @return ResourceCollection
     * @queryParam filter[name] required Free-form search string of a user's name. Max 64 characters. Example: Mike
     * @response {
     *   "data": [
     *      {"name":"Mike Daniels","username":"super7"},
     *      {"name":"Mike Oak","username":"mike.oak"}
     *   ]
     * }
     */
    public function search(Request $request)
    {

        $request->validate([
            'filter.name' => 'nullable|string|max:64'
        ]);

        $users = QueryBuilder::for(User::class)
            ->allowedFilters('name', 'username')
            ->orderBy('name', 'asc')
            ->paginate(30);


        return SearchResultResource::collection($users);
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
