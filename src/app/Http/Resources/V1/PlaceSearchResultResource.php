<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceSearchResultResource extends JsonResource
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
                'name' => $this['description'],
                'uid' => $this['place_id']
            ];
    }

}
