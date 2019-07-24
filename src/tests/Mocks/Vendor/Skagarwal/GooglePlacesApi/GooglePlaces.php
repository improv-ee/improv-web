<?php

namespace Tests\Mocks\Vendor\Skagarwal\GooglePlacesApi;

use Illuminate\Support\Collection;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;

class GooglePlaces
{

    const TEST_PLACE_NAME = 'Some School Mock Test';
    const TEST_404_PLACE_UID = 'not_found_uid';

    public function placeDetails($uid, $params = [])
    {
        if ($uid === self::TEST_404_PLACE_UID) {
            throw new GooglePlacesApiException;
        }

        return new Collection([
            'result' => [
                'name' => self::TEST_PLACE_NAME,
                'url' => 'https://sqroot.eu',
                'formatted_address' => 'Kasemäe 22, Kunda, 44107 Lääne-Viru maakond'
            ]
        ]);
    }

    public function placeAutocomplete($input, $params = [])
    {
        return new Collection(
            [
                'predictions' => [
                    [
                        'place_id' => 'xxx',
                        'description' => 'test1'
                    ], [
                        'place_id' => 'xxxxxx2',
                        'description' => 'Test location 2'
                    ],
                ]
            ]);
    }

}