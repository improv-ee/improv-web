<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Orm\Filters\FilterTranslatedName;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class OrganizationController
 * @group Organizations
 *
 */
class OrganizationController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Organization::class, 'organization');
    }

    /**
     * @param Organization $organization
     * @return OrganizationResource
     */
    public function show(Organization $organization)
    {
        return new OrganizationResource($organization);
    }

    public function index(Request $request)
    {
        $organizations = QueryBuilder::for(Organization::class)
            ->allowedFilters(Filter::custom('name', FilterTranslatedName::class))
            ->orderBy('id', 'desc')
            ->onlyMine($request->input('onlyMine', false))
            ->paginate(30);
        return OrganizationResource::collection($organizations);
    }

    /**
     * @param Request $request
     * @return OrganizationResource
     * @authenticated
     * @bodyParam name string required Name of the organization. Example: Loose Moose
     * @responseFile 200 api-doc/v1/responses//organizations/store.200.json
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|filled|unique:organization_translations|max:255|min:2',
        ]);

        $organization = new Organization;

        $organization->fill($request->all());
        $organization->creator_id = $request->user()->id;
        $organization->save();

        $membership = new OrganizationUser;
        $membership->user_id = Auth::user()->id;
        $membership->role = OrganizationUser::ROLE_ADMIN;
        $membership->creator_id = Auth::user()->id;
        $membership->organization_id = $organization->id;
        $membership->save();

        return new OrganizationResource($organization);
    }

    /**
     * @param Organization $organization
     * @param UpdateOrganizationRequest $request
     * @return OrganizationResource
     * @authenticated
     */
    public function update(Organization $organization, UpdateOrganizationRequest $request)
    {
        $organization->fill($request->all())->save();
        return new OrganizationResource($organization);
    }

    /**
     * @param Organization $organization
     * @throws \Exception
     * @authenticated
     */
    public function destroy(Organization $organization)
    {

        $organization->delete();
    }
}
