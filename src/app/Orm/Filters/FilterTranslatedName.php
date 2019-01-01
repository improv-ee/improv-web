<?php

namespace App\Orm\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterTranslatedName implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->whereHas('translations', function (Builder $q) use ($value) {
            $q->where('name', 'LIKE', '%' . $value . '%')
                ->where('locale', app()->getLocale());
        });
    }
}