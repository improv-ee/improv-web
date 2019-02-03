<?php

namespace App\Http\Services;

use App\Http\Services\Traits\SavesMediaTrait;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationStorageService
{
    use SavesMediaTrait;

    /**
     * @param Organization $organization
     * @param Request $request
     * @return Organization
     */
    public function save(Organization $organization, Request $request): Organization
    {

        $organization->fill($request->all());
        $organization->creator_id = $request->user()->id;

        DB::transaction(function () use ($organization, $request) {
            $organization->save();

            $this->syncMedia($request, $organization);
        });

        return $organization;
    }

    /**
     * @param Organization $organization
     * @param User $creator
     * @return OrganizationUser
     */
    public function addCreatorAsMember(Organization $organization, User $creator): OrganizationUser
    {
        $membership = new OrganizationUser;
        $membership->user_id = $creator->id;
        $membership->role = OrganizationUser::ROLE_ADMIN;
        $membership->creator_id = $creator->id;
        $membership->organization_id = $organization->id;
        $membership->save();

        return $membership;
    }
}