<?php

namespace App\Http\Resources;

use App\Orm\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'events' => EventResource::collection($this->events),
            'title' => $this->title,
            'slug' => $this->slug,
            'images' => [
                'header' => $this->header_img_id ? new ImageResource($this->header_img) : null
            ],
            'description' => $this->description,
            'excerpt' => $this->excerpt,
        ];
    }
}
