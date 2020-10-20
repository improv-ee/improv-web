<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gigad\DeleteGigadRequest;
use App\Http\Requests\Gigad\StoreGigadRequest;
use App\Http\Requests\Gigad\UpdateGigadRequest;
use App\Http\Resources\V1\GigadResource;
use App\Http\Services\GigadStorageService;
use App\Orm\Gigad;
use App\Orm\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Gigads
 */
class GigadController extends Controller
{
    /**
     * @var GigadStorageService
     */
    private GigadStorageService $gigadStorageService;

    /**
     * @param GigadStorageService $gigadStorageService
     */
    public function __construct(GigadStorageService $gigadStorageService)
    {
        $this->gigadStorageService = $gigadStorageService;
    }


    /**
     * Show Gigad details
     *
     * @param Gigad $gigad
     * @return JsonResource
     */
    public function show(Gigad $gigad): JsonResource
    {
        return new GigadResource($gigad);
    }

    /**
     * List all Gigads
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $gigads = QueryBuilder::for(Gigad::class)
            ->allowedFilters([
                AllowedFilter::exact('is_public'),
                AllowedFilter::exact('gig_category_id'),
                AllowedFilter::exact('organization.uid')
            ])
            ->orderBy('id', 'asc')
            ->onlyMine($request->input('onlyMine', false))
            ->paginate(15);

        return GigadResource::collection($gigads);
    }

    /**
     * Create a new Gigad
     *
     * @param StoreGigadRequest $request
     * @return GigadResource
     * @authenticated
     * @bodyParam description string Long (markdown-enabled) description of the organization
     * @bodyParam is_public boolean Whether or not to show this publicly
     * @bodyParam link string Link to "read more"
     * @bodyParam int gig_category_id Numeric category ID
     * @bodyParam string organization_uid Organization who owns this
     */
    public function store(StoreGigadRequest $request)
    {

        $gigad = new Gigad;
        $gigad->setToken();

        $this->gigadStorageService->update($gigad,$request);

        return new GigadResource($gigad);
    }

    /**
     * Update an ad
     *
     * @param Gigad $gigad
     * @param UpdateGigadRequest $request
     * @return GigadResource
     * @bodyParam description string Long (markdown-enabled) description of the organization
     * @bodyParam is_public boolean Whether or not to show this publicly
     * @bodyParam link string Link to "read more"
     * @bodyParam int gig_category_id Numeric category ID
     * @bodyParam string organization_uid Organization who owns this
     * @authenticated
     */
    public function update(Gigad $gigad, UpdateGigadRequest $request)
    {

        $this->gigadStorageService->update($gigad,$request);
        return new GigadResource($gigad);
    }


    /**
     * Delete a Gigad
     *
     * @param Gigad $gigad
     * @param DeleteGigadRequest $request
     * @throws \Exception
     * @authenticated
     */
    public function destroy(Gigad $gigad, DeleteGigadRequest $request)
    {
        $gigad->delete();
    }
}
