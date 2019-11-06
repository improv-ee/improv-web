<?php

namespace App\Policies;

use App\Orm\Organization;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the organization user.
     *
     * @param \App\User $user
     * @param Organization $organization
     * @return bool
     */
    public function view(?User $user, Organization $organization): bool
    {
        return true;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create organization users.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user !== null;
    }

    public function addMember(User $user, Organization $organization): bool
    {

        return $organization->isAdmin($user);
    }

    public function removeMember(User $user, Organization $organization): bool
    {

        return $organization->isAdmin($user);
    }

    /**
     * Determine whether the user can update the organization user.
     *
     * @param \App\User $user
     * @param Organization $organization
     * @return bool
     */
    public function update(User $user, Organization $organization): bool
    {
        return $organization->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the organization user.
     *
     * @param \App\User $user
     * @param Organization $organization
     * @return bool
     */
    public function delete(User $user, Organization $organization): bool
    {
        return $organization->isAdmin($user);
    }

    /**
     * Determine whether the user can restore the organization user.
     *
     * @param \App\User $user
     * @param Organization $organization
     * @return bool
     */
    public function restore(User $user, Organization $organization): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the organization user.
     *
     * @param \App\User $user
     * @param Organization $organization
     * @return bool
     */
    public function forceDelete(User $user, Organization $organization): bool
    {
        return false;
    }
}
