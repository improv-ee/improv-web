<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductionResource extends JsonResource
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
            'events' => EventResource::collection($this->events),
            'title' => $this->title,
            'slug' => $this->slug,
            'header_img'=>$this->header_img,
            'description'=>$this->description,
            'excerpt'=>$this->excerpt,
        ];
    }
}
