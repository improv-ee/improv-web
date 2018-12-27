<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductionStoreRequest;
use App\Http\Resources\ProductionResource;
use App\Orm\Image;
use App\Orm\OrganizationProduction;
use App\Orm\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProductionController
 *
 */
class ProductionController extends Controller
{
    public function show($id)
    {
        return new ProductionResource(Production::whereTranslation('slug', $id)
            ->firstOrFail());
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
        $production->fill($request->all($production->getFillable()));
        $production->creator_id = $request->user()->id;
        $production->save();
        return new ProductionResource($production);
    }

    public function update($id, Request $request)
    {
        $production = Production::whereTranslation('slug', $id)->firstOrFail();

        $image = Image::where('uid', $request->post('header_img'))->first();
        if ($image) {
            $production->header_img_id = $image->id;
        }
        $production->fill($request->all($production->getFillable()))->save();
        return new ProductionResource($production);
    }

    public function destroy($id)
    {
        $production = Production::whereTranslation('slug', $id)
            ->firstOrFail();
        $production->delete();
    }
}
