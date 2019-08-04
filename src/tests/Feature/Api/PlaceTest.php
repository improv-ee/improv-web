<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\Mocks\Vendor\Skagarwal\GooglePlacesApi\GooglePlaces;

/**
 * @covers \App\Http\Controllers\Api\V1\PlaceController
 * @package Tests\Feature\Api
 */
class PlaceTest extends ApiTestCase
{
    use DatabaseMigrations;

    const TEST_SESSION_ID = 'ab3bb390-abe8-11e9-a2a3-2a2ae2dbcce4';

    public function testPlaceSearchReturnsExpectedResults()
    {
        $this->actingAsLoggedInUser();

        $response = $this->get($this->getApiUrl() . '/places/search?filter[name]=test&session=' . self::TEST_SESSION_ID);
        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'uid' => GooglePlaces::TEST_PLACE_UID,
                    'name' => 'test1',
                ]
            ]]);
    }

    public function testInvalidSearchQueryIsRejected()
    {
        $this->actingAsLoggedInUser();

        $query = Str::random(1000);
        $response = $this->get($this->getApiUrl() . '/places/search?filter[name]=' . $query . '&session=' . self::TEST_SESSION_ID);

        $response->assertStatus(422);
    }


    public function testNotLoggedInUserIsNotAuthorized()
    {

        $response = $this->get($this->getApiUrl() . '/places/search?filter[name]=test&session=' . self::TEST_SESSION_ID);

        $response->assertStatus(401);
    }
}
