<?php

namespace App\Http\Controllers\Api\Organization;

use App\Events\Organization\UserJoined;
use App\Http\Controllers\Controller;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;

class MembershipController extends Controller
{

    public function store(string $slug, User $user)
    {
        $organization = Organization::whereTranslation('slug', $slug)
            ->firstOrFail();

        $membership = OrganizationUser::getMembership($user->id, $organization->id);

        if ($membership !== null) {
            return response(['errors' => ['title' => 'Membership already exists']], 400);
        }

        $member = new OrganizationUser;
        $member->user_id = $user->id;
        $member->organization_id = $organization->id;
        $member->role = OrganizationUser::ROLE_MEMBER;
        $member->save();

        event(new UserJoined($member));

        return response(null, 201);
    }
}