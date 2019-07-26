<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\PlaceException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlaceSearchResultResource;
use App\Contracts\Services\PlaceService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Places
 *
 * Places are physical locations where events might happen.
 * Places list is provided by [Google Places API](https://developers.google.com/places/web-service/autocomplete).
 */
class PlaceController extends Controller
{

    /**
     * @var PlaceService
     */
    private $placeService;

    public function __construct(PlaceService $placeService)
    {
        $this->placeService = $placeService;
    }


    /**
     * Search for a Place
     *
     * This is meant to be used for autocomplete search operations, where an user tries to identify
     * a Place by it's name. The output from this operation is Place `uid`, which is Google's UID for a Place.
     *
     * If the search input is empty or a Place is not found, an empty `data` array is returned.
     * @param Request $request
     * @return ResourceCollection|array
     * @queryParam filter[name] required Free-form search string of a place name or address, ie "white house". Max 64 characters. Example: Estonia
     * @queryParam session required A self-generated UUID token for this autocomplete session. Needs to be [RFC 4122](https://tools.ietf.org/html/rfc4122) compliant and unique per session, but reused between "search changed" requests. See [sessiontoken](https://developers.google.com/places/web-service/autocomplete) parameter documentation in Google API docs. Example: cce45caf-3a0d-427f-86ea-6a3f6a5a94ac
     * @response {
     *   "data": [
     *      {"name":"Nationaloper Estonia, Estonia puiestee, Tallinn, Eesti","uid":"ChIJ_Rhj05-UkkYRtR_QXJ7vBLA"},
     *      {"name":"Teater Club, Vabaduse v\u00e4ljak, Tallinn, Estonia","uid":"ChIJeWB2iZ6UkkYRe2QssVpp8z4"}
     *   ]
     * }
     */
    public function search(Request $request)
    {

        $request->validate([
            'filter.name' => 'nullable|string|max:64',
            'session' => 'required|string|uuid'
        ]);

        $query = $request->input('filter.name');

        if (empty($query)) {
            return ['data' => []];
        }

        try {
            $searchResults = $this->placeService->searchByName($query, [
                'sessiontoken' => $request->input('session')
            ]);
        } catch (PlaceException $e) {
            return ['data' => []];
        }


        return PlaceSearchResultResource::collection($searchResults);
    }
}
