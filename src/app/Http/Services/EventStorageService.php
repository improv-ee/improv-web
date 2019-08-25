<?php

namespace App\Http\Services;

use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Services\Traits\SavesMediaTrait;
use App\Orm\Event;
use App\Orm\Place;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventStorageService
{
    use SavesMediaTrait;

    /**
     * @param Event $event
     * @param UpdateEventRequest $request
     * @return Event
     * @throws \Exception
     */
    public function save(Event $event, UpdateEventRequest $request): Event
    {

        $this->setPlaceToEvent($request, $event);

        $event->start_time = new Carbon($request->input('times.start'));
        $event->end_time = new Carbon($request->input('times.end'));
        $event->creator_id = $request->user()->id;

        $event->title = $request->post('title');
        $event->description = $request->post('description');

        $event->save();

        DB::transaction(function () use ($event, $request) {
            $event->save();
            $this->syncMedia($request, $event);
        });

        return $event;
    }

    /**
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return Event
     */
    private function setPlaceToEvent(UpdateEventRequest $request, Event $event): Event
    {
        if ($request->input('place.uid') !== null) {
            $place = Place::firstOrCreate(['uid' => $request->input('place.uid')]);
            $event->place_id = $place->id;
        } else {
            $event->place_id = null;
        }
        return $event;
    }
}