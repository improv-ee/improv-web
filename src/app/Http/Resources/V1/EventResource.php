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
                'self' => route('api.events.show', ['event' => $this->uid]),
                'production' => route('api.productions.show', ['production' => $this->production->uid])
            ],
            'images'=> new HeaderImageResource($this)
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('Last-Modified', $this->updated_at->format('D, d M Y H:i:s \G\M\T'));
    }
}
