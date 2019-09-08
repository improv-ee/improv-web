<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\Image\HeaderImageResource;
use App\Orm\Place;
use App\Orm\Production;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Place $place
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property string $uid
 * @property string $title
 * @property string $description
 * @property Production $production
 * @property int $id
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

        return [
            'uid' => $this->uid,
            'title' => $this->title,
            'description' => $this->description,
            'production' => [
                'uid' => $this->production->uid,
                'title' => $this->production->title
            ],
            'times' => [
                'start' => $this->start_time->toIso8601String(),
                'end' => $this->end_time->toIso8601String()
            ],
            'place' => new PlaceResource($this->place),
            'links' => [
                'self' => route('api.events.show', ['uid' => $this->uid]),
                'production' => route('api.productions.show', ['id' => $this->production->uid])
            ],
            'images'=> new HeaderImageResource($this)
        ];
    }
}
