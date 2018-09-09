<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Orm\Production;

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
}
