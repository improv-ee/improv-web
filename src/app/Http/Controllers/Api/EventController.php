<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Orm\Event;

class EventController extends Controller
{
    public function show ($uid)
    {
        $event = Event::where('uid', $uid)->first();
        return new EventResource($event);
    }

    public function index() {
        return EventResource::collection(Event::orderBy('id','desc')->paginate());
    }
}
