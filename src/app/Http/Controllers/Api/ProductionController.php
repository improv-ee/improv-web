<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Production\DeleteProductionRequest;
use App\Http\Requests\Production\ProductionStoreRequest;
use App\Http\Requests\Production\UpdateProductionRequest;
use App\Http\Resources\ProductionResource;
use App\Orm\Image;
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
    public function show(Production $production) : JsonResource
    {
        return new ProductionResource($production);
    }

    public function index(Request $request)
    {

        $query = Production::orderBy('created_at', 'desc');

        if ($request->input('onlyMine', false)) {
            $query->belongingToUser(Auth::user());
        }

        $productions = $query->paginate(30);

        return ProductionResource::collection($productions);
    }

    public function store(ProductionStoreRequest $request)
    {
        $production = new Production;
        $production->fill($request->all());
        $production->creator_id = $request->user()->id;
        $production->save();
        return new ProductionResource($production);
    }

    public function update(Production $production, UpdateProductionRequest $request)
    {

        $image = Image::where('uid', $request->post('header_img'))->first();

        if ($image) {
            $production->header_img_id = $image->id;
        }
        $production->fill($request->all())->save();
        return new ProductionResource($production);
    }

    public function destroy(Production $production, DeleteProductionRequest $request)
    {
        $production->delete();
    }
}
