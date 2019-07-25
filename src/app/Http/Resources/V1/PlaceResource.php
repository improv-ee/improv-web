<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;

/**
 * @property string uid
 */
class PlaceResource extends JsonResource
{

    /**
     * @var
     */
    protected $placeDetails;


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $placesApi = resolve('GooglePlaces');

        // Google's Maps/Places API terms do not allow to save Place details to local database
        // Hence we must do a remove call each time to display them
        try {
            $this->placeDetails = $placesApi->placeDetails($this->uid, [
                'language' => App::getLocale(),
                'fields' => 'formatted_address,name,url'
            ]);
        } catch (GooglePlacesApiException $e) {
            return [
                'uid' => $this->uid
            ];
        }

        return [
            'uid' => $this->uid,
            'name' => $this->placeDetails['result']['name'],
            'address' => $this->placeDetails['result']['formatted_address'],
            'url' => $this->placeDetails['result']['url']
        ];
    }

}
