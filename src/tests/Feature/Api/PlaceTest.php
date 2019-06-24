<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;

/**
 * @covers \App\Http\Controllers\Api\V1\PlaceController
 * @package Tests\Feature\Api
 */
class PlaceTest extends ApiTestCase
{
    use DatabaseMigrations;


    public function testPlaceSearchReturnsExpectedResults()
    {
        $this->actingAsLoggedInUser();

        $response = $this->get($this->getApiUrl() . '/places/search?query=test');
        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'place_id' => 'xxx',
                    'description' => 'test1',
                ]
            ]]);
    }

    public function testInvalidSearchQueryIsRejected()
    {
        $this->actingAsLoggedInUser();

        $query = Str::random(1000);
        $response = $this->get($this->getApiUrl() . '/places/search?query=' . $query);

        $response->assertStatus(422);
    }
}
