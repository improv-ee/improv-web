<?php

namespace App\Http\Controllers\Api\Organization;

use App\Events\Organization\UserJoined;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\MembershipUpdateRequest;
use App\Http\Resources\Organization\MembershipResource;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{

    public function show(Organization $organization, User $user)
    {
        $membership = OrganizationUser::where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return new MembershipResource($membership);
    }


    public function store(Organization $organization, Request $request)
    {

        $this->authorize('addMember', $organization);

        $user = User::where('username', $request->input('username'))->firstOrFail();
        $membership = OrganizationUser::getMembership($user->id, $organization->id);

        if ($membership !== null) {
            return response(['errors' => ['title' => 'Membership already exists']], 400);
        }

        $member = new OrganizationUser;
        $member->user_id = $user->id;
        $member->organization_id = $organization->id;
        $member->role = OrganizationUser::ROLE_MEMBER;
        $member->creator_id = Auth::user()->id;
        $member->save();

        event(new UserJoined($member));

        return response(null, 201);
    }

    public function update(Organization $organization, User $user, MembershipUpdateRequest $request){

        $membership = OrganizationUser::getMembership($user->id, $organization->id);

        $membership->role = $request->input('role');
        $membership->save();

    }

    public function destroy(Organization $organization, User $user)
    {
        $this->authorize('removeMember',$organization);

        $membership = OrganizationUser::where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $membership->delete();
    }
}