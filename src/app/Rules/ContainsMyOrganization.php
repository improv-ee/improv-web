<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

/**
 * Validates that a list of Organizations (by slug) contains at least one Organization that the current user belongs to
 *
 * Input $value = ['slug-1', 'slug-2']
 *
 * @package App\Rules
 */
class ContainsMyOrganization implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!$value || !is_array($value) || !count($value) || !Auth::check()) {
            return false;
        }

        $myOrganizations = $this->geMyOrganizations(Auth::user());

        foreach ($value as $organization) {
            if (in_array($organization,$myOrganizations)) {
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
     * Get a list of Organization slugs where the User is a member of
     *
     * @param User $user
     * @return array
     */
    private function geMyOrganizations(User $user):array
    {
        return $user->organizations()
            ->get()
            ->pluck('slug')
            ->toArray();
    }
}
