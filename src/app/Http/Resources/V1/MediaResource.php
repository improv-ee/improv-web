<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'uid' => $this->uid,
            'filename' => $this->filename,
            'url' => route('api.images.show', ['uid' => $this->uid]),
            'links' => [
                'self' => route('api.images.show', ['uid' => $this->uid])
            ]
        ];
    }
}
