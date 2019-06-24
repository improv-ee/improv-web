<?php

namespace Tests\Mocks\Vendor\Skagarwal\GooglePlacesApi;

use Illuminate\Support\Collection;

class GooglePlaces
{
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