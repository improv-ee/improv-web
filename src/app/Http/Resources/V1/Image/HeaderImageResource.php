<?php

namespace App\Http\Resources\V1\Image;

use App\Orm\Place;
use App\Orm\Production;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

/**
 * @property HasMedia $this
 */
class HeaderImageResource extends JsonResource
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
            'header' => $this->when($this->hasMedia('images'), [
                'urls' => [
                    'original' => $this->getFirstMediaUrl('images')
                ]
            ], null)
        ];
    }
}
