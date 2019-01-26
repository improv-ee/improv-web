<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'avatar' => Gravatar::src($this->email)
        ];
    }
}
