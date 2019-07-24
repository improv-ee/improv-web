<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use SKAgarwal\GoogleApi\PlacesApi;

/**
 * Places are physical locations where events might happen
 *
 * @group Place
 */
class PlaceController extends Controller
{
    /**
     * @var PlacesApi
     */
    private $places;

    public function __construct()
    {
        $this->places = resolve('GooglePlaces');
    }


    /**
     * Search for a Place using free text input
     *
     * @param Request $request
     * @return array
     * @queryParam filter[name] string required Freeform search string of a place name or address, ie "white house"
     * @queryParam session string required A self-generated UUID token for this autocomplete session. Needs to be  RFC 4122 compliant and unique per session, but reused between "search changed" requests.
     * @throws \SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException
     */
    public function search(Request $request): array
    {

        $request->validate([
            'filter.name' => 'nullable|string|max:255',
            'session' => 'required|string|uuid'
        ]);

        $query = $request->input('filter.name');

        if (empty($query)) {
            return ['data' => []];
        }

        $searchResults = $this->places->placeAutocomplete($query, [
            'language' => App::getLocale(),
            'sessiontoken' => $request->input('session'),
            'components' => config('improv.allowed_places')
        ]);

        $results = [];

        foreach ($searchResults->get('predictions') as $result) {
            $results[] = [
                'name' => $result['description'],
                'uid' => $result['place_id']
            ];
        }

        return [
            'data' => $results,
        ];
    }


    public function show()
    {
        ['s' => $place = $this->places->placeDetails('ChIJS8ier1-TkkYRx_FWLYhRklM', [
            'language' => App::getLocale(),
            'fields' => ['address_component', 'adr_address', 'formatted_address', 'name']
        ])];
    }
}
