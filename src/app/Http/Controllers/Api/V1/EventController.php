<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\DeleteEventRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\V1\EventResource;
use App\Http\Resources\V1\ScheduleResource;
use App\Orm\Event;
use App\Orm\Production;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Events
 *
 * Events are concrete occurrences of a particular Production. They have beginning and end times and venue locations.
 *
 * An Event is identified by its `uid` parameter, which is a randomly generated unique value.
 */
class EventController extends Controller
{


    /**
     * Show Event details
     *
     * Get information about a particular Event.
     *
     * @param $uid
     * @return EventResource
     */
    public function show($uid)
    {
        $event = Event::where('uid', $uid)
            ->first();
        return new EventResource($event);
    }

    /**
     * @return mixed
     */
    private function getNextEvents()
    {
        return Event::orderBy('start_time', 'asc')
            ->whereDate('start_time', '>=', Carbon::now(config('app.timezone')))
            ->paginate();
    }

    /**
     * List all Events
     *
     * Get a paginated list of all Events
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return EventResource::collection($this->getNextEvents());
    }

    /**
     * Show upcoming Events
     *
     * Returns a paginated list of Events in the future, ordered by start time.
     * This is useful to show a view of "next upcoming Events".
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function schedule()
    {
        return ScheduleResource::collection($this->getNextEvents());
    }

    /**
     * Create a new Event
     *
     * Stores a new Event
     *
     * @bodyParam times.start date required Start time
     * @bodyParam times.end date required End time
     * @bodyParam title string Title of the Event, if different from that of the Production
     * @bodyParam description string Description of the Event, if different from that of the Production
     * @bodyParam production.uid string required Production to which the event belongs under
     * @param StoreEventRequest $request
     * @return JsonResource
     * @authenticated
     */
    public function store(StoreEventRequest $request) : JsonResource
    {

        $request->validate(['production.uid' => 'required|max:64']);

        $production = Production::where('uid', $request->post('production')['uid'])
            ->firstOrFail();

        $event = new Event;

        $event->start_time = new Carbon($request->post('times')['start']);
        $event->end_time = new Carbon($request->post('times')['end']);
        $event->production_id = $production->id;
        $event->creator_id = $request->user()->id;
        $event->save();

        return new EventResource($event);
    }

    /**
     * Update an Event
     *
     * Change Event details
     *
     * @bodyParam times.start date required Start time
     * @bodyParam times.end date required End time
     * @bodyParam title string Title of the Event, if different from that of the Production
     * @bodyParam description string Description of the Event, if different from that of the Production
     * @param Event $event
     * @param UpdateEventRequest $request
     * @return JsonResource
     * @authenticated
     */
    public function update(Event $event, UpdateEventRequest $request): JsonResource
    {

        $event->start_time = new Carbon($request->post('times')['start']);
        $event->end_time = new Carbon($request->post('times')['end']);
        $event->title = $request->post('title');
        $event->description = $request->post('description');

        $event->save();
        return new EventResource($event);
    }

    /**
     * Delete an Event
     *
     * @param Event $event
     * @param DeleteEventRequest $request
     * @throws \Exception
     * @authenticated
     */
    public function destroy(Event $event, DeleteEventRequest $request) : void
    {
        $event->delete();
    }
}
