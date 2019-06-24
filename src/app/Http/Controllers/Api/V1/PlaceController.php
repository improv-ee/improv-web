<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SKAgarwal\GoogleApi\PlacesApi;

/**
 * Places are physical locations where events might happen
 *
 * @group Place
 */
class PlaceController extends Controller
{


    /**
     * Search for a Place using free text input
     *
     * @param Request $request
     * @return array
     * @queryParam query Freeform search string of a place name or address, ie "white house"
     * @throws \SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException
     */
    public function search(Request $request): array
    {

        $request->validate([
            'query' => 'required|alpha_dash|max:255',
        ]);

        /** @var PlacesApi $places */
        $places = resolve('GooglePlaces');

        $query = $request->query('query');
        $searchResults = $places->placeAutocomplete($query);

        $results = [];

        foreach ($searchResults->get('predictions') as $result) {
            $results[] = [
                'description' => $result['description'],
                'place_id' => $result['place_id']
            ];
        }

        return [
            'data' => $results
        ];
    }


}
