<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\ScheduleResource;
use App\Orm\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function show ($uid)
    {
        $event = Event::where('uid', $uid)
            ->where('deleted_at',null)
            ->first();
        return new EventResource($event);
    }

    private function getNextEvents(){
        return Event::orderBy('start_time','asc')
            ->where('deleted_at',null)
            ->whereDate('start_time','>=',Carbon::now(config('app.timezone')))
            ->paginate();
    }
    public function index() {
        return EventResource::collection($this->getNextEvents());
    }

    public function schedule() {
        return ScheduleResource::collection($this->getNextEvents());
    }
}
