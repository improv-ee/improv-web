<?php

namespace App\Http\Resources\V1;

use App\Orm\Place;
use App\Orm\Production;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

/**
 * @property Place $place
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property string $uid
 * @property string $title
 * @property string $description
 * @property Production $production
 */
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        // Cache Place resource for 24h
        // It is unlikely to change during this time; and computing it is expensive
        $place = $this->place;
        $placeResource = null;
        if ($place !== null) {
            $placeResource = Cache::remember('PlaceResource:' . $this->place->uid, 86400, function () use ($place) {
                return new PlaceResource($place);
            });
        }

        return [
            'uid' => $this->uid,
            'title' => $this->title,
            'description' => $this->description,
            'production' => [
                'uid' => $this->production->uid
            ],
            'times' => [
                'start' => $this->start_time->toIso8601String(),
                'end' => $this->end_time->toIso8601String()
            ],
            'place' => $placeResource,
            'links' => [
                'self' => route('api.events.show', ['uid' => $this->uid]),
                'production' => route('api.productions.show', ['id' => $this->production->uid])
            ]
        ];
    }
}
