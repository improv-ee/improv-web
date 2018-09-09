<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uid' => $this->uid,
            'title' => $this->title,
            'description'=>$this->description,
            'production'=> new ProductionResource($this->production),
            'start_time'=>$this->start_time->toIso8601String(),
            'end_time'=>$this->end_time->toIso8601String(),
            'links' => [
                'self' => route('api.events.show',['uid'=>$this->uid])
            ]
        ];
    }
}
