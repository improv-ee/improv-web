<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\ScheduleResource;
use App\Orm\Event;
use App\Orm\Production;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class EventController
 * @group Events
 */
class EventController extends Controller
{


    public function show($uid)
    {
        $event = Event::where('uid', $uid)
            ->first();
        return new EventResource($event);
    }

    private function getNextEvents()
    {
        return Event::orderBy('start_time', 'asc')
            ->whereDate('start_time', '>=', Carbon::now(config('app.timezone')))
            ->paginate();
    }

    public function index()
    {
        return EventResource::collection($this->getNextEvents());
    }

    public function schedule()
    {
        return ScheduleResource::collection($this->getNextEvents());
    }

    public function store(EventStoreRequest $request)
    {

        $request->validate(['production.slug' => 'required|max:255']);

        $production = Production::whereTranslation('slug', $request->post('production')['slug'])
            ->firstOrFail();

        $event = new Event;

        $event->start_time = new Carbon($request->post('times')['start']);
        $event->end_time = new Carbon($request->post('times')['end']);
        $event->production_id = $production->id;
        $event->creator_id = $request->user()->id;
        $event->save();

        return new EventResource($event);
    }

    public function update($id, EventStoreRequest $request)
    {

        $event = Event::where('uid', $id)->firstOrFail();
        $event->start_time = new Carbon($request->post('times')['start']);
        $event->end_time = new Carbon($request->post('times')['end']);
        $event->title = $request->post('title');
        $event->description = $request->post('description');

        $event->save();
        return new EventResource($event);
    }

    public function destroy($id)
    {
        $event = Event::where('uid', $id)
            ->firstOrFail();
        $event->delete();

    }
}
