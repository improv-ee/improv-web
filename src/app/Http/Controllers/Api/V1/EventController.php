<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\DeleteEventRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\V1\EventResource;
use App\Http\Resources\V1\ScheduleResource;
use App\Http\Services\EventStorageService;
use App\Orm\Event;
use App\Orm\Place;
use App\Orm\Production;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

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
     * @var EventStorageService
     */
    private $eventStorageService;

    /**
     * EventController constructor.
     * @param EventStorageService $eventStorageService
     */
    public function __construct(EventStorageService $eventStorageService)
    {
        $this->eventStorageService = $eventStorageService;
    }

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
     * @param int $count
     * @return mixed
     */
    private function getNextEvents(int $count = 15)
    {
        return Event::orderBy('start_time', 'asc')
            ->whereDate('start_time', '>=', Carbon::now(config('app.timezone')))
            ->paginate($count);
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
        return ScheduleResource::collection($this->getNextEvents(17));
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
     * @bodyParam place.uid string required UID of the Place where this event happens
     * @param StoreEventRequest $request
     * @authenticated
     * @return JsonResource
     * @throws \Exception
     */
    public function store(StoreEventRequest $request) : JsonResource
    {

        $request->validate(['production.uid' => 'required|max:64']);

        $event = new Event;

        $production = Production::where('uid', $request->input('production.uid'))
            ->firstOrFail();

        $event->production_id = $production->id;

        $this->eventStorageService->save($event, $request);
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
     * @bodyParam place.uid string required UID of the Place where this event happens
     * @param Event $event
     * @param UpdateEventRequest $request
     * @authenticated
     * @return JsonResource
     * @throws \Exception
     */
    public function update(Event $event, UpdateEventRequest $request) : JsonResource
    {
        $this->eventStorageService->save($event, $request);
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
    public function destroy(Event $event, DeleteEventRequest $request): void
    {
        $event->delete();
    }
}
