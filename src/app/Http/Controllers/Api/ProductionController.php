<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Orm\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function show ($id)
    {
        return new ProductionResource(Production::whereTranslation('slug', $id)
            ->where('deleted_at',null)
            ->first());
    }

    public function index() {
        $productions = Production::where('deleted_at', null)
            ->orderBy('created_at', 'desc')
            ->paginate(30);
        return ProductionResource::collection($productions);
    }

    public function store(Request $request){
        $production = new Production;
        $production->fill($request->all());
        $production->slug = str_slug($request->post('title'));
        $production->creator_id = $request->user()->id;
        $production->save();
        return new ProductionResource($production);
    }

    public function update($id, Request $request){
        $production = Production::whereTranslation('slug',$id)->firstOrFail();

        $production->fill($request->all(['description','title','excerpt']))->save();
        return new ProductionResource($production);
    }
}
