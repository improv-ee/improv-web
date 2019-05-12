<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * This validator checks that the username is not one of the below reserved words
 *
 * @package App\Rules
 */
class ReservedUsername implements Rule
{

    /**
     * This is a list of reserved usernames, compiled from various sources.
     * Many of them are profanities, some of them are system-related (administrator),
     * some of them are in this list by mistake (the list is not particularly pre-curated and will be changed on
     * per-need basis).
     *
     * If you are easily offended, stop reading here.
     *
     * If you have a problem with any of the entries, open a relevant pull request to change it.
     */
    protected function getReservedList(): array
    {
        return json_decode(file_get_contents(resource_path('lists/reserved-usernames.json')));
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !in_array($value, $this->getReservedList());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.reservedusername');
    }
}
