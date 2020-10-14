<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\Image\HeaderImageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
class ScheduleResource extends JsonResource
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
            'images' => new HeaderImageResource($this),
            'production'=> [
                'title' => $this->production->title,
                'uid' => $this->production->uid,
                'images' => new HeaderImageResource($this->production),
                'description'=>$this->production->description,
                'excerpt'=>$this->production->excerpt,
                'tags' => TagResource::collection($this->production->tags)
            ],
            'times' => [
                'start'=>$this->start_time->toIso8601String(),
                'end'=>$this->end_time->toIso8601String()
            ],
            'links' => [
                'self' => route('api.events.show',['event'=>$this->uid]),
                'production' => route('api.productions.show',['production'=>$this->production->uid])
            ]
        ];
    }
}
