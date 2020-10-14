<?php

namespace App\Http\Resources\V1;

use App\Contracts\Services\PlaceService;
use App\Exceptions\PlaceException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use mastani\GoogleStaticMap\Format;
use mastani\GoogleStaticMap\GoogleStaticMap;
use mastani\GoogleStaticMap\MapType;
use mastani\GoogleStaticMap\Size;

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

        try {

            $placeUid = $this->uid;

            // Cache Place resource
            // It is unlikely to change during this time; and computing it is expensive
            $placeDetails = Cache::remember('PlaceDetails:' . $placeUid, 604800, function () use ($placeUid, $placeService) {
                Log::info(
                    'Could not find a cached version of a Place, need to re-fetch it from remote API', [
                    'placeId' => $placeUid,
                ]);

                return $placeService->getPlaceDetails($placeUid);
            });

        } catch (PlaceException $e) {
            return [
                'uid' => $this->uid
            ];
        }

        return [
            'uid' => $this->uid,
            'name' => $placeDetails['name'],
            'address' => $placeDetails['formatted_address'],
            'urls' => [
                'maps' => $placeDetails['url'],
                'staticImage' => $placeService->getStaticPlaceImageUrl($placeDetails['formatted_address'], $placeDetails['name'])
            ]
        ];
    }

}
