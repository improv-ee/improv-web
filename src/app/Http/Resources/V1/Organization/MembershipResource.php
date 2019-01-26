<?php

namespace App\Http\Resources\V1\Organization;

use App\Http\Resources\V1\OrganizationResource;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
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
            'organization' => new OrganizationResource($this->organization),
            'user' => new UserResource($this->user),
            'role' => $this->role
        ];
    }
}
