<?php

namespace Tests\Mocks\Vendor\Skagarwal\GooglePlacesApi;

use Illuminate\Support\Collection;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;

class GooglePlaces
{

    const TEST_PLACE_NAME = 'Some School Mock Test';
    const TEST_PLACE_UID = 'cce45caf-3a0d-427f-86ea-6a3f6a5a94ac';
    const TEST_404_PLACE_UID = 'not_found_uid';
    const TEST_PLACE_URL = 'https://sqroot.eu';

    public function placeDetails($uid, $params = [])
    {
        if ($uid === self::TEST_404_PLACE_UID) {
            throw new GooglePlacesApiException;
        }

        return new Collection([
            'result' => [
                'name' => self::TEST_PLACE_NAME,
                'url' => self::TEST_PLACE_URL,
                'formatted_address' => 'Kasemäe 22, Kunda, 44107 Lääne-Viru maakond'
            ]
        ]);
    }

    public function placeAutocomplete($input, $params = [])
    {
        return new Collection(
            [
                'predictions' => new Collection([
                    [
                        'place_id' => self::TEST_PLACE_UID,
                        'description' => 'test1'
                    ], [
                        'place_id' => 'xxxxxx2',
                        'description' => 'Test location 2'
                    ],
                ])
            ]);
    }

}