<?php

namespace App\Http\Controllers\Api;

use App\Events\Organization\UserJoined;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class OrganizationController
 *
 */
class OrganizationController extends Controller
{
    /**
     * @param $id
     * @return OrganizationResource
     */
    public function show($id)
    {
        return new OrganizationResource(Organization::whereTranslation('slug', $id)
            ->firstOrFail());
    }

    public function index(Request $request)
    {
        $organizations = Organization::orderBy('created_at', 'desc')
            ->onlyMine($request->input('onlyMine', false))
            ->paginate(30);
        return OrganizationResource::collection($organizations);
    }

    public function store(Request $request)
    {
        $organization = new Organization;

        $organization->fill($request->all($organization->getFillable()));
        $organization->creator_id = $request->user()->id;
        $organization->save();
        return new OrganizationResource($organization);
    }

    public function update($id, Request $request)
    {
        $organization = Organization::whereTranslation('slug', $id)->firstOrFail();

        $organization->fill($request->all($organization->getFillable()))->save();
        return new OrganizationResource($organization);
    }

    public function destroy($id)
    {
        $organization = Organization::whereTranslation('slug', $id)
            ->firstOrFail();
        $organization->delete();
    }

    public function join($slug)
    {
        $organization = Organization::whereTranslation('slug', $slug)
            ->firstOrFail();

        $userId = Auth::user()->id;
        $membership = OrganizationUser::getMembership($userId, $organization->id);

        if ($membership !== null) {
            return response(['errors' => ['title' => 'Membership already exists']], 400);
        }

        $member = new OrganizationUser;
        $member->user_id = $userId;
        $member->organization_id = $organization->id;
        $member->role = OrganizationUser::ROLE_JOINER;
        $member->save();

        event(new UserJoined($member));

        return response(null, 201);
    }
}
