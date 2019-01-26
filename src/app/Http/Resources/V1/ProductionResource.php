<?php

namespace App\Http\Resources\V1;

use App\Orm\Production;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProductionResource
 * @package App\Http\Resources
 * @property Production $this
 */
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
            'organizations' => $this->when($this->organizations()->count(), $this->getOrganizationCollection())
        ];
    }

    /**
     * @return array
     */
    private function getOrganizationCollection()
    {
        $organizations = [];
        foreach ($this->organizations()->get() as $organization) {
            $organizations[] = [
                'slug' => $organization->slug,
                'name' => $organization->name
            ];
        }
        return $organizations;
    }
}
