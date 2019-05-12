<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

/**
 * Custom Tag model for spatie-tags package
 *
 * @package App\Orm
 */
class Tag extends \Spatie\Tags\Tag
{
    const TYPE_PRODUCTION = 'production';

    /**
     * @param string $slug
     * @param string|null $type
     * @param string|null $locale
     * @return Tag|null|Model
     */
    public static function findFromSlug(string $slug, string $type = null, string $locale = null) : ?self
    {
        $locale = $locale ?? app()->getLocale();

        return static::query()
            ->where("slug->{$locale}", $slug)
            ->where('type', $type)
            ->first();
    }

    /**
     * Encode the given value as JSON.
     *
     * Overwrites parent method and sets UNICODE to be unescaped
     *
     * @param  mixed  $value
     * @return string
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
