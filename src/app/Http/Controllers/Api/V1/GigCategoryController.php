<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Gig\CategoryResource;
use App\Orm\GigCategory;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


/**
 * @group Gigs
 *
 * Gig categories categorize gig ads
 * Examples: Performance, workshop
 */
class GigCategoryController extends Controller
{
    /**
     * List all Gig categories
     */
    public function index()
    {

        $categories = QueryBuilder::for(GigCategory::class)
            ->allowedFilters([
                AllowedFilter::exact('gigads.is_public')
            ])
            ->orderBy('order', 'asc')
            ->paginate(15);

        return CategoryResource::collection($categories);
    }
}
