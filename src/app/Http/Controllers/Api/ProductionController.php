<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Production\DeleteProductionRequest;
use App\Http\Requests\Production\StoreProductionRequest;
use App\Http\Requests\Production\UpdateProductionRequest;
use App\Http\Resources\ProductionResource;
use App\Http\Services\ProductionStorageService;
use App\Orm\Production;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProductionController
 *
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


    public function show(Production $production): JsonResource
    {
        return new ProductionResource($production);
    }

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

    public function store(StoreProductionRequest $request)
    {
        $production = new Production;
        $production->creator_id = $request->user()->id;

        $production = $this->productionStorageService->saveProduction($production, $request);
        return new ProductionResource($production);
    }

    public function update(Production $production, UpdateProductionRequest $request)
    {
        $production = $this->productionStorageService->saveProduction($production, $request);
        return new ProductionResource($production);
    }

    public function destroy(Production $production, DeleteProductionRequest $request)
    {
        $production->delete();
    }
}
