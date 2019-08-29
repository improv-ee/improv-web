<?php

namespace App\Services;

use App\Contracts\Services\PlaceService as PlaceServiceContract;
use App\Exceptions\PlaceException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;
use SKAgarwal\GoogleApi\PlacesApi;

class PlaceService implements PlaceServiceContract
{

    /**
     * @var PlacesApi;
     */
    private $placesApi;

    public function __construct()
    {
        $this->placesApi = resolve('GooglePlaces');
    }

    /**
     * @param string $name
     * @param array $args
     * @return array
     * @throws PlaceException
     */
    public function searchByName(string $name, array $args = []): Collection
    {

        $args = array_replace([
            'language' => App::getLocale(),
            'components' => config('improv.allowed_places')
        ], $args);

        try {
            $searchResults = $this->placesApi->placeAutocomplete($name, $args);
            Log::info('Searching Google Places for a Place', [
                'searchTerm' => $name,
                'resultsCount' => $searchResults->get('predictions')->count()
            ]);

        } catch (GooglePlacesApiException $e) {
            throw new PlaceException($e->getMessage(), $e->getCode(), $e);
        }
        return $searchResults->get('predictions');
    }

    /**
     * @param string $uid
     * @param array $args
     * @return Collection
     * @throws PlaceException
     */
    public function getPlaceDetails(string $uid, array $args = []): array
    {
        $args = array_replace([
            'language' => App::getLocale(),
            'fields' => 'formatted_address,name,url'
        ], $args);

        try {
            Log::info('Requesting Place details from Google Places', [
                'placeUid' => $uid
            ]);
            return $this->placesApi->placeDetails($uid, $args)['result'];
        } catch (GooglePlacesApiException $e) {
            throw new PlaceException($e->getMessage(), $e->getCode(), $e);
        }
    }
}