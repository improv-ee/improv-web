<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Orm\Production;

class ProductionController extends Controller
{
    public function show ($id)
    {
        return new ProductionResource(Production::find($id));
    }

    public function index() {
        return ProductionResource::collection(Production::paginate());
    }
}
