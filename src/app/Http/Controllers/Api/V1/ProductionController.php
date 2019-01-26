<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Production\DeleteProductionRequest;
use App\Http\Requests\Production\StoreProductionRequest;
use App\Http\Requests\Production\UpdateProductionRequest;
use App\Http\Resources\V1\ProductionResource;
use App\Http\Services\ProductionStorageService;
use App\Orm\Production;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProductionController
 * @group Productions
 */
class ProductionController extends Controller
{
    /**
     * @var ProductionStorageService
     */
    private $productionStorageService;

    public function __construct(ProductionStorageService $productionStorageService)
    {
        $this->productionStorageService = $productionStorageService;
    }

    /**
     * Show Production details
     *
     * @param Production $production
     * @return JsonResource
     */
    public function show(Production $production): JsonResource
    {
        return new ProductionResource($production);
    }

    /**
     * List all Productions
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Production::orderBy('created_at', 'desc');

        if ($request->input('onlyMine', false)) {
            if (Auth::user() === null) {
                return response(null,403);
            }
            $query->belongingToUser(Auth::user());
        }

        $productions = $query->paginate(30);

        return ProductionResource::collection($productions);
    }

    /**
     * Create a new Production
     *
     * @param StoreProductionRequest $request
     * @return ProductionResource
     * @bodyParam title string required
     * @bodyParam description string
     * @bodyParam excerpt string
     * @bodyParam organizations array required List of Organizations who "own" this Production
     * @authenticated
     */
    public function store(StoreProductionRequest $request)
    {
        $production = new Production;
        $production->creator_id = $request->user()->id;

        $production = $this->productionStorageService->saveProduction($production, $request);
        return new ProductionResource($production);
    }

    /**
     * Update Production details
     *
     * @param Production $production
     * @param UpdateProductionRequest $request
     * @return ProductionResource
     * @bodyParam title string required
     * @bodyParam description string
     * @bodyParam excerpt string
     * @bodyParam organizations array required List of Organizations who "own" this Production
     * @authenticated
     */
    public function update(Production $production, UpdateProductionRequest $request)
    {
        $production = $this->productionStorageService->saveProduction($production, $request);
        return new ProductionResource($production);
    }

    /**
     * Delete a Production
     *
     * @param Production $production
     * @param DeleteProductionRequest $request
     * @throws \Exception
     * @authenticated
     */
    public function destroy(Production $production, DeleteProductionRequest $request)
    {
        $production->delete();
    }
}
