<?php

namespace App\Rules;

use App\Orm\Tag;
use Illuminate\Contracts\Validation\Rule;

class TagExists implements Rule
{
    /**
     * @var string
     */
    private $type;

    /**
     * Create a new rule instance.
     *
     * @param string $type
     */
    public function __construct(string $type = 'production')
    {
        $this->type = $type;
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
        if ($value === null) {
            return true;
        }

        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $tag) {
            if (Tag::findFromSlug($tag, $this->type) === null) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.tag_does_not_exist');
    }
}
