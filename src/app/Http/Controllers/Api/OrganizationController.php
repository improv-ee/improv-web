<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Orm\Organization;
use Illuminate\Http\Request;

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
}
