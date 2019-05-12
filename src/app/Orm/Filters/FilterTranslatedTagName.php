<?php

namespace App\Orm\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * Filter spatie-tags for spatie-querybuilder based on translatable name
 *
 * https://docs.spatie.be/laravel-tags/v2/basic-usage/using-tags
 * https://github.com/spatie/laravel-query-builder
 *
 * @package App\Orm\Filters
 */
class FilterTranslatedTagName implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->containing($value);
    }
}