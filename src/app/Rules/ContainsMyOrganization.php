<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

/**
 * Validates that a list of Organizations (by uid) contains at least one Organization that the current user belongs to
 *
 * If input value is not an array, it's taken as a list of exactly one Organization UID-s;
 * and the rule validates if the given Organization is in the list of user-belonging orgs.
 *
 * Input $value = ['da1aFa', 'aj7Fa']
 *
 * @package App\Rules
 */
class ContainsMyOrganization implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        if (is_string($value)) {
            $value = [$value];
        }
        if (!$value || !is_array($value) || !count($value) || !Auth::check()) {
            return false;
        }

        $myOrganizations = $this->geMyOrganizations(Auth::user());

        foreach ($value as $organization) {
            if (in_array($organization, $myOrganizations)) {
                return true;
            }
        }

        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.organization.list_must_contain_mine');
    }

    /**
     * Get a list of Organization uid-s where the User is a member of
     *
     * @param User $user
     * @return array
     */
    private function geMyOrganizations(User $user): array
    {
        return $user->organizations()
            ->get()
            ->pluck('uid')
            ->toArray();
    }
}
