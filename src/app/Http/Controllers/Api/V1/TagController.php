<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TagResource;
use App\Orm\Filters\FilterTranslatedTagName;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Tags\Tag;

/**
 * @group Tags
 *
 * A Tag is a label that can be applied to other objects. For example, a Production can have a Tag of "workshop".
 *
 * An Tag is identified by its `slug` attribute.
 */
class TagController extends Controller
{


    /**
     * List all Tags
     *
     * @param Request $request
     * @queryParam filter[name] Filter results based on Tag's `name`
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        $tags = QueryBuilder::for(Tag::class)
            ->allowedFilters(AllowedFilter::custom('name', new FilterTranslatedTagName))
            ->orderBy('id', 'asc')
            ->paginate(50);

        return TagResource::collection($tags);
    }

}
