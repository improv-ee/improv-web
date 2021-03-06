<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\Image\HeaderImageResource;
use App\Orm\GigCategory;
use App\Orm\Organization;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Organization $organization
 * @property GigCategory $category
 * @package App\Http\Resources\V1
 */
class GigadResource extends JsonResource
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
            'uid' => $this['uid'],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ],
            'organization' => [
                'uid' => $this->organization->uid,
                'name' => $this->organization->name
            ],
            'link'=> $this['link'],
            'description' => $this['description'],
            'times' => [
                'updated_at'=>$this['updated_at']->toIso8601String()
            ],
            'is_public' => $this['is_public'],
            'images' => new HeaderImageResource($this)
        ];
    }

}
