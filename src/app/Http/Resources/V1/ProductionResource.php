<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\Image\HeaderImageResource;
use App\Http\Resources\V1\Minimal\OrganizationResource;
use App\Orm\Organization;
use App\Orm\Production;
use App\Orm\Tag;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @package App\Http\Resources
 * @property Production $this
 * @property Organization|Collection $organizations
 * @property Tag|Collection $tags
 * @property string $excerpt
 * @property string $description
 * @property string $uid
 * @property bool $hasUpcomingEvents
 * @property string $title
 * @property Collection $events
 */
class ProductionResource extends JsonResource
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
            'events' => EventResource::collection($this->events),
            'hasUpcomingEvents' => $this->hasUpcomingEvents,
            'title' => $this->title,
            'uid' => $this->uid,
            'images' => new HeaderImageResource($this),
            'description' => $this->description,
            'excerpt' => $this->excerpt,
            'organizations' => $this->when($this->organizations()->count(), OrganizationResource::collection($this->organizations)),
            'tags' => $this->when($this->tags()->count(), TagResource::collection($this->tags))
        ];
    }

}
