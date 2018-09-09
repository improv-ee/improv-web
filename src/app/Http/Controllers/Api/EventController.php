<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Orm\Event;

class EventController extends Controller
{
    public function show ($id)
    {
        return new EventResource(Event::find($id));
    }

    public function index() {
        return EventResource::collection(Event::orderBy('id','desc')->paginate());
    }
}
