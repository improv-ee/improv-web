<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @package App\Http\Resources\V1
 * @property string $name
 * @property string $slug
 * @property string $type
 */
class TagResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type
        ];
    }
}
