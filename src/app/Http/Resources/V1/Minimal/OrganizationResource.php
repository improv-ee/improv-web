<?php

namespace App\Http\Resources\V1\Minimal;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Minimal representation of an Organization - enough to ID it
 * @package App\Http\Resources\V1\Minimal
 */
class OrganizationResource extends JsonResource
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
            'uid' => $this->uid
        ];
    }
}
