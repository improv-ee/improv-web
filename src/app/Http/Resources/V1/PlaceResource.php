<?php

namespace App\Http\Resources\V1;

use App\Contracts\Services\PlaceService;
use App\Exceptions\PlaceException;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string uid
 */
class PlaceResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $placeService = resolve(PlaceService::class);

        // Google's Maps/Places API terms do not allow to save Place details to local database
        // Hence we must do a remove call each time to display them
        try {
            $placeDetails = $placeService->getPlaceDetails($this->uid);
        } catch (PlaceException $e) {
            return [
                'uid' => $this->uid
            ];
        }

        return [
            'uid' => $this->uid,
            'name' => $placeDetails['name'],
            'address' => $placeDetails['formatted_address'],
            'url' => $placeDetails['url']
        ];
    }

}
